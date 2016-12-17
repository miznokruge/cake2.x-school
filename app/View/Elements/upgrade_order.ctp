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
    echo $this->Form->create('Order',array('class' => 'order-form', 'style' => 'width:100%;'));
?>
<input type="hidden" name="suggest_edit" value="<?php echo $this->Array->Get($suggest,'id');?>">
<h5>Customer</h5>
    <div class="customer_info" style="height:250px;">
<?php
        $customer_attr = array('name', 'phone', 'phone_alt', 'email', 'company');
        $req_attr = array('address', 'city');
        foreach($customer_attr as $ca){
            echo $this->Form->input('Customer.'.$ca, array('value' => $customer[$ca]));
        }
        foreach($req_attr as $ra){
            echo $this->Form->input('Customer.'.$ra, array('value' => $customer[$ra],
                'div' => 'input text required', 'maxlength' => '1000'));
        }
?>
    </div>
<h5>Items to Order:</h5>
<div class="items">
<div class="order_buys">
<?php        
    $exist_order_buy = '';
    $this->Form->supp_stats = ( isset($sup) ) ? $sup : NULL;
    foreach ($buy as $b){        
        $exist_order_buy .= $this->Form->orderBuyHtml($suppliers,$showDiscount,$b);
    }
    //$order_buy = $this->Form->orderBuyHtml($suppliers,$showDiscount);
    echo $exist_order_buy;
    //echo $order_buy;    
?>
</div>
<!--a href="#" id="add_order_buy">+</a-->
</div>
<?php
    $existOrderSuppliers = '';
    foreach ($orderSupplier as $supplier){
        $osupp = $supplier['OrdersSupplier'];      
        $existOrderSuppliers .= $this->Form->ordersSuppliersHtml($suppliers, $osupp);
    }
    $order_supplier = $this->Form->ordersSuppliersHtml($suppliers);    
    $existOrderShippings = '';
    foreach ($shippings as $shipping){
        $existOrderShippings .= $this->Form->ordersShippingsHtml($shippers, $shipping);
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
<div class="order_buy_a">
	<p><label class="checkbox"><input type="checkbox" id="ckAddress">Sama Dengan Alamat di atas.</label></p>	
	<p>
	<label class="label-required">Alamat Pengiriman </label>
	<textarea class="validate[required]" name="data[Order][ship_address]" placeholder="Alamat Pengiriman"><?php echo (!empty($order['ship_address']))?$order['ship_address'] : $customer['address'];?></textarea>
	</p>
	<p>
	<label class="label-required">Kota Tujuan </label>
	<input class="validate[required]" type="text" name="data[Order][ship_city]" placeholder="Kota Tujuan" value="<?php echo (!empty($order['ship_city']))?$order['ship_city'] : $customer['city'];?>">
	</p>
</div>
<h5>Harga Pengiriman (Tambahkan bila ada)</h5>
<div class="shippings" style="padding:10px 0;">
    <div class="order_shippings" style="padding:0;">
        <?php echo $existOrderShippings ?>
    </div>
    <a href="#" id="add_order_shipping">+</a>    
</div>
<h5>Supplier: Pengiriman dan DP</h5>
<div class="supplier_down_payments" style="padding:10px 0;">
    <div class="order_suppliers" style="padding:0;">
<?php echo $existOrderSuppliers; ?>
    </div>    
    <a href="#" id="add_order_supplier">+</a>    
</div>
<h5>Payment Info</h5>
<div class="customer_dp">
<?php    echo $this->Form->input('dp_customer', array('label' => 'DP dari Customer'
            ,'type' => 'text', 'class' => 'auto'
            ,'placeholder' => 'Rp', 'div' => 'input text required', 'value' => $dpCustomer)); ?>
<?php echo $this->Form->input('term_of_payment', array('type' => 'select','options' => $top, 'label' => 'jatuh tempo'
                ,'class' => 'auto', 'class' => 'term_of_payment','div' => 'input text required'));?>   
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
<?php
    echo $this->Form->end(__('Submit'));
    echo $this->element('open_lead_script', array(
        //'order_buy'      => $order_buy,
        'order_supplier' => $order_supplier,
        'order_shipping' => $order_shipping
    )); 
?>
<script type="text/javascript">
$(document).ready(function(){
    $('#notes').scrollToFixed();
});
</script>