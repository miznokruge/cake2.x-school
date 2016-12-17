<?php

class PaymentlibComponent extends Component {

    public $components = array(
        'Arr'
    );
	/**
	* 	moving out this function from controller to component for reuse.
	*	@param id numeric id of outpayment
	*	@param returnTotal boolean return array or total 
	*	
	*	@return array
	*/
    public function getPOWithPrice($id,$returnTotal = FALSE) 
    {
        //$poConditions = array();
		$this->Pos = ClassRegistry::init('Po');
        $db = $this->Pos->getDataSource();
        $query = $db->buildStatement(
                array('fields' => array('Po.*', 'os.supplier_id', 'os.dp', 'os.buy_price', 'sup.*', 'ship.buy_price')
            , 'table' => $db->fullTableName($this->Pos)
            , 'alias' => 'Po'
            , 'joins' => array(
                array(
                    'table' => 'orders_suppliers',
                    'alias' => 'os',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Po.supplier_id = os.supplier_id 
                                            AND Po.order_id = os.order_id'
                    )
                ),             
                array(
                    'table' => 'shippings',
                    'alias' => 'ship',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Po.supplier_id = ship.supplier_id 
                                            AND Po.order_id = ship.order_id'
                    )
                ),
                array(
                    'table' => 'suppliers',
                    'alias' => 'sup',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Po.supplier_id = sup.id'
                    )
                )
            )
            , 'conditions' => array('Po.outpayment_id = ' => $id)
            , 'order' => 'Po.sent_at DESC'
            , 'limit' => '100'
            , 'group' => ''
                ), $this->Pos
        );
        $results = $this->Pos->query($query);

		if( $returnTotal === TRUE )
		{
	        // Calculate total value of po
	        $total = array('buy_price' => 0.0, 'dp' => 0.0, 'shipping' => 0.0);
	        foreach ($results as $po) {
	            $total['buy_price'] += $po['os']['buy_price'];
	            //$total['dp'] += $po['os']['dp'];
	            $total['shipping'] += $po['ship']['buy_price'];
	        }

	        $results['total'] = $total;
		}

        return $results;
    }

    public function sumTotalPo(array $po_prices)
    {
    	$result = 0;
    	foreach( $po_prices as $price )
    	{
    		$result += floatval($price);
    	}

    	return $result;
    }
}