<a class="help" onclick="toggleWaitPaymentHelp();" href="javascript:void(0);" data-toggle="tooltip" title="available twig markup eg: {{Invoice.invoiceID}}"><i class="icon-question-sign"></i></a>	    	
<div id="WaitPaymentHelp" style="background-color:#F9F9F9;display:none;">
<?php 
echo <<<'EOD'
Payment.trans_code<br>
Customer.name<br>
Customer.phone<br>
Customer.phone_alt<br>
Customer.email<br>
Customer.address<br>
Customer.city<br>
Customer.company<br>
Customer.asal<br>
Customer.created<br>
InvoiceID<br>
Current_Date
EOD;
?>	    		
</div>	
<?php 	
	$WaitPayment = $this->Array->Get($configs,'WAIT_PAYMENT',array());
	$waitbank_config = json_decode($WaitPayment['Jconfig']['extra'],TRUE);
	$WaitPayment_cfg = ( !empty($WaitPayment) ) ? $WaitPayment['Jconfig'] : array();
	$WaitPayment_debet = $this->Jurnal->getConfig($WaitPayment['JurnalConfig'],'debet');
	$WaitPayment_kredit = $this->Jurnal->getConfig($WaitPayment['JurnalConfig'],'kredit');
?>
<form id="fmWaitPayment" class="jurnal_config" method="POST" action="<?php echo $this->webroot;?>jurnalconfigs/save">	    		
	<input type="hidden" name="main_id" value="<?php echo $this->Array->Get($WaitPayment_cfg,'id',5);?>">	
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
		    				<?php echo $this->Form->drop_down_entry($coas,array('default' => $waitbank_config['banks'][$bank['Bank']['short_name']]));?>
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
			<td><input style="width:75%;" type="text" name="extra[entry_date]"" value="<?php echo $this->Array->Get($waitbank_config,'entry_date');?>"></td>
		</tr>		
		<tr>
			<td style="width:10%;"><label class="control-label">Voucher Number</label></td>
			<td><input style="width:75%;" type="text" name="voucher_number" value="<?php echo $WaitPayment_cfg['voucher_number'];?>"></td>
		</tr>
    	<tr>
    		<td style="width:10%;"><label class="control-label">Nama Transaksi</label></td>	    			
			<td><input style="width:75%;" type="text" name="nama_transaksi" value="<?php echo $WaitPayment_cfg['nama_transaksi'];?>"></td>
		</tr>
	</table>
	<!-- WaitPayment DEBET Block -->
	<div class="span5">
		<h4>Debet</h4>
		<input type="hidden" name="debet[id]" value="<?php echo isset($WaitPayment_debet['id']) ? $WaitPayment_debet['id'] : NULL;?>" style="display:inline;">
		<label class="checkbox"><input type="radio" name="use_bank" value="debet" <?php echo ($waitbank_config['use_bank'] == 'debet') ? 'checked="checked"' : '';?>>Use Bank Account</label>		
		<div class="jurnal-container">
			<div class="jurnal-content">
				<label>Rekening</label>
				<select name="debet[coa_id]" class="rekening">
					<option value="0">-- Pilih Rekening --</option>
					<?php echo $this->Form->drop_down_entry($coas, array('default' => isset($WaitPayment_debet['coa_id']) ? $WaitPayment_debet['coa_id'] : NULL) );?>
				</select>
				<label>Nama/Keterangan Transaksi</label>
				<textarea name="debet[nama_transaksi]" style="width: 90%; height: 120px;"><?php echo isset($WaitPayment_debet['nama_transaksi']) ? $WaitPayment_debet['nama_transaksi'] : NULL;?></textarea>		    				
			</div>
			<!-- Tax -->
			<?php $WaitPayment_Tax_Debet = $this->Jurnal->getTaxConfig($configs['WAIT_PAYMENT']['JurnalConfig'],'debet');?>		
			<label class="checkbox"><input onclick="toggleTax(this);" type="checkbox" name="debet[use_tax][on]" value="1" <?php echo (is_array($WaitPayment_Tax_Debet))? 'checked="checked"': '';?>>Use Tax?</label>	    					    		
    		<div class="jurnal-container" <?php echo (is_array($WaitPayment_Tax_Debet)) ? '' : 'style="display:none;"';?>>		
 				<label>Rekening</label>
				<select name="debet[use_tax][coa_id]" class="rekening">
					<option value="0">-- Pilih Rekening --</option>
					<?php echo $this->Form->drop_down_entry($coas, array('default' => isset($WaitPayment_debet['tax_coa']) ? $WaitPayment_debet['tax_coa'] : NULL) );?>
				</select>  	   			
    			<h4>Pajak</h4>
    			<input type="hidden" name="debet[tax][id]" value="<?php echo isset($WaitPayment_Tax_Debet) ? $WaitPayment_Tax_Debet['id'] : NULL;?>" style="display:inline;">			    			    			
    			<div class="jurnal-content">
    				<label>Rekening</label>
    				<select name="debet[tax][coa_id]" class="rekening">
    					<option value="0">-- Pilih Rekening --</option>
    					<?php echo $this->Form->drop_down_entry($coas,array('default' => isset($WaitPayment_Tax_Debet) ?$WaitPayment_Tax_Debet['coa_id'] : NULL));?>
    				</select>	   				
    				<label>Nama/Keterangan Transaksi</label>
    				<textarea name="debet[tax][nama_transaksi]" style="width: 90%; height: 90px;"><?php echo isset($WaitPayment_Tax_Debet) ? $WaitPayment_Tax_Debet['nama_transaksi'] : NULL;?></textarea>		    							    						    				    				
    			</div>		    			
    		</div>	
		</div>		    		
	</div>
	<!-- END SendPO Debet Block -->
	<!-- SendPO KREDIT Block -->
	<div class="col-sm-">
		<h4>Kredit</h4>
		<input type="hidden" name="kredit[id]" value="<?php echo isset($WaitPayment_kredit['id']) ? $WaitPayment_kredit['id'] : NULL;?>" style="display:inline;">		    		
		<label class="checkbox"><input type="radio" name="use_bank" value="kredit" <?php echo ($waitbank_config['use_bank'] == 'kredit') ? 'checked="checked"' : '';?>>Use Bank Account</label>
		<div class="jurnal-container">			
			<div class="jurnal-content">
				<label>Rekening</label>
				<select name="kredit[coa_id]" class="rekening">
					<option value="0">-- Pilih Rekening --</option>
					<?php echo $this->Form->drop_down_entry($coas,array('default' => isset($WaitPayment_kredit['coa_id']) ? $WaitPayment_kredit['coa_id'] : NULL));?>
				</select>	
				<label>Nama/Keterangan Transaksi</label>
				<textarea name="kredit[nama_transaksi]" style="width: 90%; height: 120px;"><?php echo isset($WaitPayment_kredit['nama_transaksi']) ? $WaitPayment_kredit['nama_transaksi'] : NULL;?></textarea>		    							    						    				    				
			</div>
			<!-- Tax -->
			<?php $WaitPayment_Tax_Kredit = $this->Jurnal->getTaxConfig($configs['WAIT_PAYMENT']['JurnalConfig'],'kredit');?>
			<label class="checkbox"><input onclick="toggleTax(this);" type="checkbox" name="kredit[use_tax][on]" value="1" <?php echo (is_array($WaitPayment_Tax_Kredit))? 'checked="checked"': '';?>>Use Tax?</label>	    					    		
    		<div class="jurnal-container" <?php echo (is_array($WaitPayment_Tax_Kredit)) ? '' : 'style="display:none;"';?>>		
				<label>Rekening</label>
				<select name="kredit[use_tax][coa_id]" class="rekening">
					<option value="0">-- Pilih Rekening --</option>
					<?php echo $this->Form->drop_down_entry($coas, array('default' => isset($WaitPayment_kredit['tax_coa']) ? $WaitPayment_kredit['tax_coa'] : NULL) );?>
				</select>  	    			
    			<h4>Pajak</h4>
    			<input type="hidden" name="kredit[tax][id]" value="<?php echo isset($WaitPayment_Tax_Kredit) ? $WaitPayment_Tax_Kredit['id'] : NULL;?>" style="display:inline;">			    			    			
    			<div class="jurnal-content">
    				<label>Rekening</label>
    				<select name="kredit[tax][coa_id]" class="rekening">
    					<option value="0">-- Pilih Rekening --</option>
    					<?php echo $this->Form->drop_down_entry($coas,array('default' => isset($WaitPayment_Tax_Kredit) ?$WaitPayment_Tax_Kredit['coa_id'] : NULL));?>
    				</select>	
    				<label>Nama/Keterangan Transaksi</label>
    				<textarea name="kredit[tax][nama_transaksi]" style="width: 90%; height: 90px;"><?php echo isset($WaitPayment_Tax_Kredit) ? $WaitPayment_Tax_Kredit['nama_transaksi'] : NULL;?></textarea>		    							    						    				    				
    			</div>		    			
    		</div>		    			
		</div>		 	    		   		    		
		<button type="submit" class="btn btn-success pull-right">Submit</button>
	</div>
	<!-- END SendPO KREDIT Block -->	    			    		    	
</form>