<?php
$top = array(
	"1 week" => "1 Minggu",
	"2 weeks" => "2 Minggu",
	"3 weeks" => "3 Minggu",
	"1 month" => "1 Bulan",
	"2 months" => "2 Bulan",
	"3 months" => "3 Bulan"
);
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
echo $this->Form->create('Order', array('class' => 'order-form'));
?>
<h5>Customer</h5>
<div class="customer_info">
	<?php
	$customer_attr = array('name', 'phone', 'phone_alt', 'email', 'company');
	$req_attr = array('address', 'city_id');
	foreach ($customer_attr as $ca) {
		echo $this->Form->input('Customer.' . $ca, array('value' => $customer[$ca]));
	}
	foreach ($req_attr as $ra) {
		echo $this->Form->input('Customer.' . $ra, array(
			'value' => $customer[$ra],
			'div' => 'input text required',
			'maxlength' => '1000')
		);
	}
	?>
</div>
<h5>Items to Order</h5>
<div class="items" style="padding:0;">
    <div class="order_buys" style="padding:0;">
		<?php
		$exist_order_buy = '';
		$this->Form->supp_stats = isset($sup) ? $supp : NULL;
		foreach ($buy as $b) {
			$exist_order_buy .= $this->Form->openBuyHtml($suppliers, $showDiscount, $b);
		}
		$order_buy = $this->Form->openBuyHtml($suppliers, $showDiscount);
		echo $exist_order_buy;
		echo $order_buy;
		?>
    </div>
    <a href="#" id="add_order_buy">+</a>
</div>
<?php
$existOrderSuppliers = '';
foreach ($orderSupplier as $supplier) {
	$osupp = $supplier['OrdersSupplier'];
	$existOrderSuppliers .= $this->Form->openSuppliersHtml($suppliers, $osupp);
}
$order_supplier = $this->Form->openSuppliersHtml($suppliers);
$existOrderShippings = '';
foreach ($shippings as $shipping) {
	$existOrderShippings .= $this->Form->openShippingsHtml($shippers, $shipping, $suppliers);
}
/* $order_shipping = '<div class="order_shipping">'
  .$this->Form->input('Shipping.shipper_supplier_id.', array('options' => $shippers,
  'type' => 'select', 'label' => 'Pengirim', 'empty' => 'Pilih', 'class' => 'shipping_order'))
  .$this->Form->input('Shipping.sell_price.', array('type' => 'text', 'label' => 'Harga ke Customer'
  ,'class' => 'auto', 'placeholder' => 'Rp', 'div' => 'input text required'))
  .$this->Form->input('Shipping.buy_price.', array('type' => 'text', 'label' => 'Modal Pengiriman'
  ,'class' => 'auto', 'placeholder' => 'Rp', 'div' => 'input text required'))
  .'<a href="#" class="remove_order_shipping">x</a>'
  .'</div>'; */
$order_shipping = $this->Form->openShippingsHtml($shippers, NULL, $suppliers);
?>
<h5>Alamat Pengiriman</h5>
<div class="order_buy_a">
	<p><label class="checkbox"><input type="checkbox" id="ckAddress" <?php echo (empty($order['ship_address']) ? 'checked' : ''); ?> >Sama Dengan Alamat di atas</label></p>	
	<p>
        <label class="label-required">Alamat Pengiriman </label>
        <textarea class="validate[required]" name="data[Order][ship_address]" placeholder="Alamat Pengiriman"><?php echo (!empty($order['ship_address'])) ? $order['ship_address'] : $customer['address']; ?></textarea>
	</p>
	<p>
		<label class="label-required">Kota Tujuan </label>
		<input class="validate[required]" type="text" name="data[Order][ship_city]" placeholder="Kota Tujuan" value="<?php echo (!empty($order['ship_city'])) ? $order['ship_city'] : $customer['city']; ?>">
	</p>
</div>
<h5>Harga Pengiriman (Tambahkan bila ada)</h5>
<div class="shippings" style="padding:10px 0;">
    <div class="order_shippings" style="padding:0;">
<?php echo $existOrderShippings ?>
    </div>
    <a href="#" id="add_order_shipping">+</a>    
</div>
<h5>Supplier (Pengiriman dan DP)</h5>
<div class="supplier_down_payments" style="padding:10px 0;">
    <div class="order_suppliers" style="padding:0;">
<?php echo $existOrderSuppliers; ?>
    </div>    
    <a href="#" id="add_order_supplier">+</a>    
</div>
<h5>Payment Info</h5>
<div class="customer_dp">
	<?php
	echo $this->Form->input('dp_customer', array(
		'label' => 'DP dari Customer',
		'type' => 'text', 'class' => 'auto',
		'placeholder' => 'Rp',
		'div' => 'input text required',
		'value' => $dpCustomer)
	);
	?>
	<?php
	echo $this->Form->input('term_of_payment', array(
		'type' => 'select',
		'options' => $top,
		'label' => 'jatuh tempo',
		'class' => 'auto',
		'class' => 'term_of_payment',
		'div' => 'input text required')
	);
	?>   
</div>
<h5>Pakai Pajak</h5>
<div class="pajak" style="margin-top:-20px;">    
	<?php
	$checked = false;
	if ($useTax > 0) {
		$checked = true;
	}
	echo $this->Form->input('use_tax', array('label' => 'Pakai Pajak (Konsumen dikenakan PPN 10%)',
		'type' => 'checkbox',
		'div' => 'input checkbox', 'value' => '1',
		'checked' => $checked
	));
	?>
</div>
<?php
echo $this->Form->end(__('Submit'));
echo $this->element('open_lead_script', array(
	'order_buy' => $order_buy,
	'order_supplier' => $order_supplier,
	'order_shipping' => $order_shipping
));
?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Stock Item</h4>
            </div>
            <div class="modal-body">
                <table class="table table-hover">
                    <thead>
					<td style="text-align:center;"><strong>No.</strong></td>
					<td style="text-align:center;"><strong>Supplier</strong></td>
					<td style="text-align:center;"><strong>Item</strong></td>
					<td style="text-align:center;"><strong>Qty</strong></td>
					<td style="text-align:center;"><strong>Price</strong></td>
					<td style="text-align:center;"><strong></strong></td>
                    </thead>
					<?php
					$i = 1;
					foreach ($stocks as $stock) {
						if ($stock['Stock']['qty'] - $stock['Stock']['onorder'] != 0) {
							echo '<tr>';
							echo '<td>' . $i . '</td>';
							echo '<td>' . $stock['suppliers']['name'] . '</td>';
							echo '<td>' . $stock['Stock']['product'] . ', ' . $stock['Stock']['bahan'] . '</td>';
							echo '<td style="text-align:right;">' . ($stock['Stock']['qty'] - $stock['Stock']['onorder']) . '</td>';
							echo '<td style="text-align:right;">Rp ' . number_format($stock['Stock']['price']) . '</td>';
							echo '<td><button type="button" id="stockLink" class="stockLink btn btn-default" data-value-id=' . $stock['Stock']['id'] . ' data-value-name=' . $stock['suppliers']['id'] . ' data-value-product="' . $stock['Stock']['product'] . '" data-value-bahan=' . $stock['Stock']['bahan'] . ' data-value-price=' . $stock['Stock']['price'] . ' data-value-qty=' . ($stock['Stock']['qty'] - $stock['Stock']['onorder']) . ' data-value-disc=' . $stock['Stock']['supplier_discount'] . ' data-value-source=' . $stock['Stock']['order_id'] . '>Add</button></td>';
							echo '</tr>';
						}
						$i++;
					}
					?>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#notes').scrollToFixed();
	});
	$('.stockLink').click(function() {
		var id = $(this).attr("data-value-id");
		var name = $(this).attr("data-value-name");
		var product = $(this).attr("data-value-product");
		var bahan = $(this).attr("data-value-bahan");
		var price = $(this).attr("data-value-price");
		var qty = $(this).attr("data-value-qty");
		var disc = $(this).attr("data-value-disc");
		var sour = $(this).attr("data-value-source");
		var src = product.toLowerCase();
		if (src.indexOf("revino") > -1) {
			$('.blp').each(function(i, obj) {
				if (obj.value == '')
					obj.setAttribute('type', 'hidden');
			});
		}
		var formVar = document.forms["OrderBaseForm"];
		var a = formVar["data[Buy][name][]"];
		var c = 1;
		if (a.length == undefined)
			c = 1;
		else
			c = a.length;
		/*$('#BuySupplierId').val(id);
		 $('#BuyName').val(product + ' (BeliFurniture)');
		 $('#BuyBahan').val(bahan);
		 $('#BuyListPrice').val(price);*/
		$('.jm').each(function(i, obj) {
			if (obj.value == '')
				obj.setAttribute('max', qty);
			if (obj.value == '')
				obj.setAttribute('min', '0');
		});
		$('.supplier_buy').each(function(i, obj) {
			if (obj.value == '0')
				obj.value = name;	
			$(this).trigger("change");			
		});
		$('.bn').each(function(i, obj) {
			if (obj.value == '')
				obj.value = '-';
		});
		$('.bb').each(function(i, obj) {
			if (obj.value == '')
				obj.value = product + ' (' + bahan + ') - BeliFurniture';
		});
		$('.blp').each(function(i, obj) {
			if (obj.value == '')
				obj.value = price;
			obj.focus();
		});
		$('.disc').each(function(i, obj) {
			if (obj.value == '')
				obj.value = disc;
			obj.focus();
		});
		$('.id').each(function(i, obj) {
			if (obj.value == '')
				obj.value = id;
			obj.focus();
		});
		$('.stbu').fadeOut();
		$('#myModal').modal('hide');
	});
	$('#add_order_buy').click(function() {
		$('.stbu').fadeOut();
		$('.id').each(function(i, obj) {
			if (obj.value == '')
				obj.value = '0';
		});
		$('.disc').each(function(i, obj) {
			if (obj.value == '')
				obj.value = '0';
		});
	});
</script>