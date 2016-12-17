<?php
    $top = array(
    		   "1 week"=>"1 Minggu",
               "2 weeks"=>"2 Minggu",
               "3 weeks"=>"3 Minggu",
               "1 month"=>"1 Bulan", 
               "2 months"=>"2 Bulan",
               "3 months"=>"3 Bulan");
?>
<style type="text/css">
	label.label-required:after{
		content: "*";
		color: #EE3322;
		display:inline;
	}
</style>
<?php
   if (!isset($showDiscount))
            $showDiscount = false;
    echo $this->Form->create('Order',array('class' => 'order-form'));
?>
<h5>Customer</h5>
<div class="customer_info">
<?php
        $customer_attr = array('name', 'phone', 'phone_alt', 'email', 'company');
        $req_attr = array('address', 'city');
        $customer_change = $this->Array->get($change_cols,'Customer');
        foreach($customer_attr as $ca){
            echo $this->Form->input('Customer.'.$ca, array(
                'value' => $customer[$ca],
                'label' => $ca.' '.$this->Suggest->markChange($customer_change,$ca),
                'style' => $this->Form->diffRed($ca,$customer_change) ));
        }
        foreach($req_attr as $ra){
            echo $this->Form->input('Customer.'.$ra, array(
                'value' => $customer[$ra],
                'div' => 'input text required',
                'label' => $ra.' '.$this->Suggest->markChange($customer_change,$ra),             
                'maxlength' => '1000',
                'style' => $this->Form->diffRed($ra,$customer_change)
            ));
        }
?>
</div>
<h5>Items to Order:</h5>
<div class="items">
<div class="order_buys">
<?php        
    $exist_order_buy = '';
    $buy_change = $this->Array->get($change_cols,'Buy');
    foreach ($buy as $idx=>$b)
    {
        $_new = FALSE; 
        if( $this->Array->get($buy_change,$idx) === '*' )
            $_new = TRUE;
        $exist_order_buy .= $this->Form->orderBuyHtml($suppliers,$showDiscount,$b,$_new,$this->Array->get($buy_change,$idx));
    }
    $order_buy = $this->Form->orderBuyHtml($suppliers,$showDiscount);
    echo $exist_order_buy;
    //echo $order_buy;    
?>
</div>
<a href="#" id="add_order_buy">+</a>
</div>
<?php
    $existOrderSuppliers = '';
    $change_orderSupplier = $this->Array->get($change_cols,'OrdersSupplier');
    foreach ($orderSupplier as $idx=>$supplier)
    {
        $osupp = $supplier['OrdersSupplier'];
        $new = FALSE;
        if( $this->Array->get($change_orderSupplier,$idx) === '*' )
            $new = TRUE; 
        $existOrderSuppliers .= $this->Form->ordersSuppliersHtml($suppliers, $osupp,$new,$this->Array->get($change_orderSupplier,$idx));
    }
    $order_supplier = $this->Form->ordersSuppliersHtml($suppliers);    
    $existOrderShippings = '';
    $shipping_change = $this->Array->get($change_cols,'Shipping');
    foreach ($shippings as $idx=>$shipping)
    {               
        $_new = FALSE;
        if( $shipping_change[$idx] === '*' )
            $_new = TRUE;        
        $existOrderShippings .= $this->Form->ordersShippingsHtml($shippers, $shipping,$_new,$shipping_change[$idx]);
    }
    $order_shipping = '<div class="order_shipping">'
            .$this->Form->input('Shipping.shipper_supplier_id.', array('options' => $shippers, 
                'type' => 'select', 'label' => 'Pengirim', 'empty' => 'Pilih', 'class' => 'shipping_order'))
            .$this->Form->input('Shipping.sell_price.', array('type' => 'text', 'label' => 'Harga ke Customer'
                ,'class' => 'auto', 'placeholder' => 'Rp', 'div' => 'input text required'))
            .$this->Form->input('Shipping.buy_price.', array('type' => 'text', 'label' => 'Modal Pengiriman'
                ,'class' => 'auto', 'placeholder' => 'Rp', 'div' => 'input text required'))
                .'<a href="#" class="remove_order_shipping">x</a>'    
                .'</div>';    
?>
<h5>Alamat Pengiriman</h5>
<?php 
$order_change = $this->Array->get($change_cols,'order');
?>
<div class="order_buy">
	<p><label class="checkbox"><input type="checkbox" id="ckAddress">Sama Dengan Alamat di atas.</label></p>	
	<p>
	<label class="label-required">Alamat Pengiriman <?php echo $this->Suggest->markChange($order_change,'ship_address');?></label>
	<textarea class="validate[required]" name="data[Order][ship_address]" placeholder="Alamat Pengiriman">
    <?php echo (!empty($order['ship_address']))?$order['ship_address'] : $customer['address'];?>
    </textarea>
	</p>
	<p>
	<label class="label-required">Kota Tujuan <?php echo $this->Suggest->markChange($order_change,'ship_city');?></label>
	<input class="validate[required]" type="text" name="data[Order][ship_city]" placeholder="Kota Tujuan" 
    value="<?php echo (!empty($order['ship_city']))?$order['ship_city'] : $customer['city'];?>">
	</p>
</div>
<h5>Harga Pengiriman (Tambahkan bila ada)</h5>
<div class="shippings">
    <div class="order_shippings">
        <?php echo $existOrderShippings ?>
    </div>
    <a href="#" id="add_order_shipping">+</a>    
</div>
<h5>Supplier: Pengiriman dan DP</h5>
<div class="supplier_down_payments">
    <div class="order_suppliers">
<?php echo $existOrderSuppliers; ?>
    </div>    
    <a href="#" id="add_order_supplier">+</a>    
</div>
<h5>Payment Info</h5>
<div class="customer_dp">
<?php    echo $this->Form->input('dp_customer', array(
    'label' => 'DP dari Customer '.$this->Suggest->markChange($change_cols['Order'],'dp_customer')
    ,'style' => $this->Form->diffRed('dp_customer',$change_cols['Order'])
    ,'type' => 'text', 'class' => 'auto'
    ,'placeholder' => 'Rp', 'div' => 'input text required'
    , 'value' => $dpCustomer
    )
    ); ?>
<?php echo $this->Form->input('term_of_payment', array(
    'type' => 'select','options' => $top
    , 'label' => 'jatuh tempo '.$this->Suggest->markChange($change_cols['Order'],'term_of_payment')
    ,'style' => $this->Form->diffRed('term_of_payment',$change_cols['Order'])
    ,'class' => 'auto', 
    'class' => 'term_of_payment',
    'div' => 'input text required'));?>   
</div>
<h5>Pakai Pajak</h5>
<div class="pajak">    
<?php
    $checked = false;
    if ($useTax > 0){
        $checked = true;
    }
    echo $this->Form->input('use_tax', array('label' => 'Pakai Pajak (Konsumen dikenakan PPN 10%)'
        ,'type' => 'checkbox'
        ,'div' => 'input checkbox', 'value' => '1'   
        ,'checked' => $checked
    )); ?>
</div>
<?php  if( (int)$suggest_order['SuggestOrder']['status'] !== 1):?>
    <button type="submit" class="btn btn-success" style="padding: 8px 10px;">Submit</button>
    <a class="btn btn-warning" href="<?php echo $this->webroot.'suggest_orders/reject/'.$suggest_id;?>">Reject Suggestion</a>   
<?php endif;?>
</form>
<?php
    echo $this->element('open_lead_script', array(
        'order_buy'      => $order_buy,
        'order_supplier' => $order_supplier,
        'order_shipping' => $order_shipping
    ));    
?>