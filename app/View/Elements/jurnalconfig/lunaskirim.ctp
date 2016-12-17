<a class="help" onclick="toggleLunasKirimHelp();" href="javascript:void(0);" data-toggle="tooltip" title="available twig markup eg: {{PO.nama_pemilik}}"><i class="icon-question-sign"></i></a>	    	
<div id="help_lunaskirim" style="background-color:#F9F9F9;display:none;">
<?php 
echo <<<'EOD'
PaymentOrder.amount<br>
PaymentOrder.sisa<br>
PaymentOrder.payment_id<br>
PaymentOrder.order_id<br>
PaymentOrder.user_id<br>
PaymentOrder.date<br>
PaymentOrder.payment_type<br>
PaymentOrder.Payment.no_seri<br>
PaymentOrder.Payment.bank<br>
PaymentOrder.Payment.date<br>
PaymentOrder.Payment.description<br>
PaymentOrder.Payment.amount<br>
PaymentOrder.Payment.balance<br>
PaymentOrder.Payment.order_id<br>
PaymentOrder.Payment.user_id<br>
PaymentOrder.Payment.path<br>
PaymentOrder.Payment.approved_by<br>
PaymentOrder.Payment.payment_type<br>
PaymentOrder.Payment.due_date<br>
PaymentOrder.Payment.trans_code<br>
Customer.name<br>
Customer.phone<br>
Customer.phone_alt<br>
Customer.email<br>
Customer.address<br>
Customer.city<br>
Customer.company<br>
Customer.asal<br>
Customer.created<br>
Customer.modified<br>
Invoice.InvoiceID<br>
Current_Date
EOD;
?>	    		
</div>	  
<?php 
	$LunasKirim = $this->Array->Get($configs,'LUNAS_KIRIM');
	$lunasbank_config = json_decode($LunasKirim['Jconfig']['extra'],TRUE);
	$LunasKirim_cfg = ( !empty($LunasKirim) ) ? $LunasKirim['Jconfig'] : array();
	$LunasKirim_debet = $this->Jurnal->getConfig($LunasKirim['JurnalConfig'],'debet');
	$LunasKirim_kredit = $this->Jurnal->getConfig($LunasKirim['JurnalConfig'],'kredit');	
?>		  	   	
<form id="fmLunasKirim" class="jurnal_config" method="POST" action="<?php echo $this->webroot;?>jurnalconfigs/save">	    		
	<input type="hidden" name="main_id" value="<?php echo $this->Array->Get($LunasKirim_cfg,'id',2);?>">
	<div class="bank-group">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Banks</th>
					<th>Accounts</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($banks as $bank):?>
				<?php if($bank['Bank']['bank_type'] === 'out'){continue;}?>
				<tr>
					<td style="width:10%;">
						<input type="hidden" name="bank[name][]" value="<?php echo $bank['Bank']['short_name'];?>">
						<label class="control-label"><?php echo $bank['Bank']['nama_bank'];?></label>
					</td>
		    		<td style="width:10%;">
		    			<select name="bank[akun][]" class="rekening">
		    				<option value="0">-- Pilih Rekening --</option>
		    				<?php echo $this->Form->drop_down_entry($coas,array('default' => $lunasbank_config['banks'][$bank['Bank']['short_name']]));?>
		    			</label>
		    		</td>	    			
				</tr>				
				<?php endforeach;?>
			</tbody>
		</table> 		
	</div>
	<hr>
	<table class="table table-striped table-bordered">
		<tr>
			<td style="width:10%;"><label class="control-label">Entry Date</label></td>
			<td><input style="width:75%;" type="text" name="extra[entry_date]" value="<?php echo $this->Array->Get($lunasbank_config,'entry_date');?>"></td>
		</tr>
		<tr>
			<td style="width:10%;"><label class="control-label">Voucher Number</label></td>
			<td><input style="width:75%;" type="text" name="voucher_number" value="<?php echo $LunasKirim_cfg['voucher_number'];?>"></td>
		</tr>
    	<tr>
    		<td style="width:10%;"><label class="control-label">Nama Transaksi</label></td>	    			
			<td><input style="width:75%;" type="text" name="nama_transaksi" value="<?php echo $LunasKirim_cfg['nama_transaksi'];?>"></td>
		</tr>
	</table>    		
	<!-- SendPO DEBET Block -->
	<div class="span5">
		<h4>Debet</h4>
		<input type="hidden" name="debet[id]" value="<?php echo isset($LunasKirim_debet['id']) ? $LunasKirim_debet['id'] : NULL;?>" style="display:inline;">
		<label class="checkbox"><input type="radio" name="use_bank" value="debet" <?php echo ($lunasbank_config['use_bank'] == 'debet') ? 'checked="checked"' : '';?>>Use Bank Account</label>	
		<div class="jurnal-container">
			<div class="jurnal-content">
				<label>Rekening</label>
				<select name="debet[coa_id]" class="rekening">
					<option value="0">-- Pilih Rekening --</option>
					<?php echo $this->Form->drop_down_entry($coas, array('default' => isset($LunasKirim_debet['coa_id']) ? $LunasKirim_debet['coa_id'] : NULL) );?>
				</select>
				<label>Nama/Keterangan Transaksi</label>
				<textarea name="debet[nama_transaksi]" style="width: 90%; height: 120px;"><?php echo isset($LunasKirim_debet['nama_transaksi']) ? $LunasKirim_debet['nama_transaksi'] : NULL;?></textarea>		    				
			</div>
			<!-- Tax -->	    					    		
			<div class="jurnal-container">	
				<h4>Pajak</h4>	
				<label>Rekening</label>
				<select name="debet[use_tax][coa_id]" class="rekening">
					<option value="0">-- Pilih Rekening --</option>
					<?php echo $this->Form->drop_down_entry($coas, array('default' => isset($LunasKirim_debet['tax_coa']) ? $LunasKirim_debet['tax_coa'] : NULL) );?>
				</select>  					    			
			</div>	
		</div>				    		
	</div>
	<!-- END SendPO Debet Block -->
	<!-- SendPO KREDIT Block -->
	<div class="col-sm-">
		<h4>Kredit</h4>
		<input type="hidden" name="kredit[id]" value="<?php echo isset($LunasKirim_kredit['id']) ? $LunasKirim_kredit['id'] : NULL;?>" style="display:inline;">		    		
		<label class="checkbox"><input type="radio" name="use_bank" value="kredit" <?php echo ($lunasbank_config['use_bank'] == 'kredit') ? 'checked="checked"' : '';?>>Use Bank Account</label>
		<div class="jurnal-container">			
			<div class="jurnal-content">
				<label>Rekening</label>
				<select name="kredit[coa_id]" class="rekening">
					<option value="0">-- Pilih Rekening --</option>
					<?php echo $this->Form->drop_down_entry($coas,array('default' => isset($LunasKirim_kredit['coa_id']) ? $LunasKirim_kredit['coa_id'] : NULL));?>
				</select>	
				<label>Nama/Keterangan Transaksi</label>
				<textarea name="kredit[nama_transaksi]" style="width: 90%; height: 120px;"><?php echo isset($LunasKirim_kredit['nama_transaksi']) ? $LunasKirim_kredit['nama_transaksi'] : NULL;?></textarea>		    							    						    				    				
			</div>	
			<!-- Tax -->  					    		
			<div class="jurnal-container">	
				<h4>Pajak</h4>		
				<label>Rekening</label>
				<select name="kredit[use_tax][coa_id]" class="rekening">
					<option value="0">-- Pilih Rekening --</option>
					<?php echo $this->Form->drop_down_entry($coas, array('default' => isset($LunasKirim_kredit['tax_coa']) ? $LunasKirim_kredit['tax_coa'] : NULL) );?>
				</select>  					    			
			</div>			
		</div>	
		<button type="submit" class="btn btn-success pull-right">Submit</button>	 	    		   		    		
	</div>
	<!-- END SendPO KREDIT Block -->	    			    		    			    		    	
</form>