<?php
App::uses('Component', 'Controller');
 /**
 * @author Mizno Kruge
 * @since Apr 20, 2013
 * Copyright "PT Tricipta Media Perkasa" all rights reserved
 */
class UpgradeOrderComponent extends Component{  
    public $user;   
    public $controller;
    var $components = array('Arr','Util', 
        'Auth' => array(
            'authorize' => array(
                'Actions' => array('actionPath' => 'controllers')
            ),
        )
    );

    function initialize(Controller $controller){  
        $this->controller = $controller;
    }  
    
    /**
    *   upgradeOrder
    *
    *   @param array $data
    *   @param array $currentOrder
    *   @param boolean $adaptRevino, if false pricelist will be fetch from database
    *
    *   @return mixed array on success, false on failure (if total price is zero)
    */
    function save($data, $currentOrder, $adaptRevino = false)
    {
       $orderId = $currentOrder['Order']['id'];
       $i = 0;
       while ($i < count($data['Buy']['name'])) {
           $data['Buy']['name'][$i] = substr($data['Buy']['name'][$i], strpos($data['Buy']['name'][$i], '+') + (strpos($data['Buy']['name'][$i], '+') == null ? 0 : 1));
           $i++;
       }

       //var_dump($data['Buy']); echo '<br><br>';

       $buys = isset($data['Buy']) ? $data['Buy'] : null;
       $orderSuppliersData = isset($data['OrderSupplier']) ? $data['OrderSupplier'] : null;
        $shippingData = isset($data['Shipping']) ? $data['Shipping'] : null;
        
        // Process Items
        //var_dump($buys); echo '<br><br>';
        $items = $this->Util->toSaveableArray($buys);
        //var_dump($items); echo '<br><br>';

        //Edit item adjust to revino
        
        if (!$adaptRevino){
            $this->adaptRevino($items);
        }

        // Process shippings
        $shippings = $this->Util->toSaveableArray($shippingData);       

        for($i = 0; $i < count($shippings); $i++)
        {
            if( !isset( $shippings[$i] ) ) continue;
            $shipSupp = $shippings[$i]['shipper_supplier_id'];
            $resp = explode('_',$shipSupp);

            if( count($resp) < 2 ) return False;

            if (is_numeric($resp[1]))
            {
                    switch($resp[0]){
                        case "supplier":
                            $shippings[$i]['supplier_id'] = intval($resp[1]);
                            $shippings[$i]['shipper_id'] = 0;
                            break;
                        case "shipper":
                            $shippings[$i]['supplier_id'] = 0;
                            $shippings[$i]['shipper_id'] = intval($resp[1]);                            
                            break;
                        default :
                            continue;
                            throw new Exception('Invalid Shipping Data: Incorrect name format for shipper_supplier_id');
                           
                    }
                    
                unset($shippings[$i]['shipper_supplier_id']);
                
                $shippings[$i]['order_id'] = $orderId;
                $shippings[$i]['sell_price'] = $this->Util->filterPrice($shippings[$i]['sell_price']);
                $shippings[$i]['buy_price'] = $this->Util->filterPrice($shippings[$i]['buy_price']);
            }
            else
            {             
                continue;  
                throw new Exception('Invalid Shipping Data: Incorrect name format for shipper_supplier_id');
            }                
        }     

         
        // Adding current order_id before saving
        $user_id = $this->UserAuth->user('id');   
        for($i = 0; $i < count($items); $i++)
        {                 
            $items[$i]['order_id'] = $orderId;
            $items[$i]['user_id'] = $user_id;
            $items[$i]['sell_price'] = $this->Util->filterPrice( $items[$i]['sell_price'] );
            $items[$i]['list_price'] = $this->Util->filterPrice( $items[$i]['list_price'] );                      
        }   

        // Process Order Supplier                
        $osupps = $this->Util->toSaveableArray($orderSuppliersData);                
        $supp_arr = $this->Util->generateSupplierBuyPrice($items);
        $osupps = $this->Util->combineSupplierOrders($supp_arr, $osupps);
        

        // Adding current order_id before saving
        for($i = 0; $i < count($osupps); $i++){
            $osupps[$i]['order_id'] = $orderId;
            $osupps[$i]['dp'] = $this->Util->filterPrice($osupps[$i]['dp']);
            $osupps[$i]['latest_delivery_date'] = date('Y-m-d 00:00:01', strtotime($osupps[$i]['latest_delivery_date']));
        }

        // Add all the price of things
        $totalItemsPrice = $this->sumItemsSellPrice($items);    
        $totalPrice = $this->sumSellPrice($items, $shippings,(int)$data['Order']['use_tax'] == 1);

        // If totalPrice is bigger than 0, start saving

        if ($totalPrice > 0)
        {               
            // Prepare all the data                      
            
            unset($data['Buy']);
            $data['Buy'] = $items;
            $data['Customer']['id'] = $currentOrder['Customer']['id'];
            $data['Order']['id'] = $currentOrder['Order']['id'];
            $data['Order']['customer_state_id'] = '2'; // Advance to waiting for payment
            $data['Order']['modified_by'] = $this->UserAuth->user('id');
            $data['Order']['sell_price'] = $totalItemsPrice;
            $data['Order']['total_sell_price'] = $totalPrice;                
            $data['Order']['buy_price'] = $this->sumItemsBuyPrice($osupps);
            $data['Order']['total_buy_price'] = $this->sumBuyPrice($osupps, $shippings);
            $data['Order']['dp_customer'] = $this->Util->filterPrice($data['Order']['dp_customer']);
            $data['Order']['term_of_payment'] = $this->Arr->get($data['Order'],'term_of_payment');
            $data['Order']['use_tax'] = $data['Order']['use_tax'];  
            $data['Order']['ship_address'] = $data['Order']['ship_address'];
            $data['Order']['ship_city'] = $data['Order']['ship_city'];              
            $data['Supplier'] = $osupps;
            $data['OrderSupplier'] = $osupps;
            if (!empty($shippings)){
                $data['Shipping'] = $shippings;                         
            }
            // Actually saving it   

            return $data;
        }
        return false;
    }
    
    public function sumSellPrice($items, $shippings,$use_tax = FALSE)
    {       
        $total = $this->sumItemsSellPrice($items);
        if( $use_tax )
        {
            $tax_value = (floatval($total) * 10) / 100;            
            $total += $tax_value;              
        }

        foreach ($shippings as $shipping)
        {         
            $total += floatval($shipping['sell_price']);
        }

        return $total;
     }                
     
     public function sumItemsSellPrice($items)
     {
        $total = 0.0;
        foreach ($items as $item){
            $num_price = $this->Util->filterPrice($item['sell_price']);
            $total += $item['qty'] * $num_price;
        }         
        return $total;
     }
     
     public function sumItemsBuyPrice($osupps)
     {
         $total = 0.0;
         for($i = 0; $i < count($osupps); $i++){
             $total += $this->Util->filterPrice($osupps[$i]['buy_price']);
         }
         return $total;         
     }
     
     public function sumBuyPrice($osupps, $shippings)
     {
         $total = $this->sumItemsBuyPrice($osupps);
         foreach ($shippings as $shipping){
             $total += $shipping['buy_price'];
         }
         return $total;
     }
     
    public function getAllShippers($list_shippers, $suppliers)
    {
        $shippers = array();
        foreach($list_shippers as $num => $shipper){
            $shippers['shipper_'.$num] = 'Ekspedisi: '.$shipper;
        }
        
        foreach($suppliers as $num => $supplier){
            $shippers['supplier_'.$num] = $supplier;
        }
        return $shippers;
    }
    
    public function addSelectedShippers($shippings){
        for($i=0; $i < count($shippings); $i++)
        {
            $shipping = $shippings[$i];
            if ($shipping['supplier_id']){
                $shippings[$i]['shipper_supplier_id'] = 'supplier_'.$shipping['supplier_id'];
            }
            else if ($shipping['shipper_id']){
                $shippings[$i]['shipper_supplier_id'] = 'shipper_'.$shipping['shipper_id'];
            }
        }
        return $shippings;
    }

    //if supplier is Revino fetch the pricelist
    //todo : clear this..
    protected function adaptRevino(&$buys)
    {
        $revino = ClassRegistry::init( 'RevinoItem' );		
        $supplier = ClassRegistry::init('Supplier');
        $supp = $supplier->find('list');
        foreach( $buys as $idx=>$buy)
        {
            if(strtolower(trim($supp[$buy['supplier_id']])) == 'revino')
            {
                $item = $revino->find('first',array('conditions' => array('name' => $buy['name'])));
                $buys[$idx]['list_price'] = $item['RevinoItem']['price_list'];
            }
        }
    }    

    //its should not here?
    public function next($orderId, $customStateId = null){
        $this->gateway($orderId);
        $Order = ClassRegistry::init('Order');
        $order = $Order->read(null, $orderId);
        $currentState = $order['State'];
        // Next state
        if ($customStateId){
            $this->Order->saveField('state_id', $customStateId);
        }
        else{
            $this->Order->saveField('state_id', $currentState['next_id']);
        }
        return true;

    }    
}