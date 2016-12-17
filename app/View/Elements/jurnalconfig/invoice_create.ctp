<a class="help" onclick="toggleInvoiceCreateHelp();" href="javascript:void(0);" data-toggle="tooltip" title="available twig markup eg: {{Invoice.invoiceID}}"><i class="icon-question-sign"></i></a>	    	
<div id="InvoiceCreateHelp" style="background-color:#F9F9F9;display:none;">
<?php 
echo <<<'EOD'
Invoice.paymentTerm<br>
Invoice.jatuh_tempo<br>
Invoice.totalShipping<br>
Invoice.InvoiceID<br>
Customer.name<br>
Customer.phone<br>
Customer.phone_alt<br>
Customer.email<br>
Customer.address<br>
Customer.city<br>
Customer.company<br>
Customer.asal<br>
Current_Date
EOD;
?>	    		
</div>
<?php 
	$InvoiceCreate = $this->Array->Get($configs,'INVOICE_CREATE',array());
	$InvoiceCreate_cfg = ( !empty($InvoiceCreate) ) ? $InvoiceCreate['Jconfig'] : array();
	$InvoiceCreate_Extra = json_decode($InvoiceCreate['Jconfig']['extra'],TRUE);
	$InvoiceCreate_debet = $this->Jurnal->getConfig($InvoiceCreate['JurnalConfig'],'debet');	
	$InvoiceCreate_kredit = $this->Jurnal->getConfig($InvoiceCreate['JurnalConfig'],'kredit');
?>	  
<form id="fmSendPo" class="jurnal_config" method="POST" action="<?php echo $this->webroot;?>jurnalconfigs/save">	    		
	<input type="hidden" name="main_id" value="<?php echo $this->Array->Get($InvoiceCreate_cfg,'id',3);?>">
	<table class="table table-striped table-bordered">
		<tr>
			<td style="width:10%;"><label class="control-label">Entry Date</label></td>
			<td><input style="width:75%;" type="text" name="extra[entry_date]"" value="<?php echo $this->Array->Get($InvoiceCreate_Extra,'entry_date');?>"></td>
		</tr>		
		<tr>
			<td style="width:10%;"><label class="control-label">Voucher Number</label></td>
			<td><input style="width:75%;" type="text" name="voucher_number" value="<?php echo $InvoiceCreate_cfg['voucher_number'];?>"></td>
		</tr>
    	<tr>
    		<td style="width:10%;"><label class="control-label">Nama Transaksi</label></td>	    			
			<td><input style="width:75%;" type="text" name="nama_transaksi" value="<?php echo $InvoiceCreate_cfg['nama_transaksi'];?>"></td>
		</tr>
	</table>    		
	<!-- SendPO DEBET Block -->
	<div class="span5">
		<h4>Debet</h4>
		<input type="hidden" name="debet[id]" value="<?php echo isset($InvoiceCreate_debet['id']) ? $InvoiceCreate_debet['id'] : NULL;?>" style="display:inline;">
		<div class="jurnal-container">
			<div class="jurnal-content">
				<label>Rekening</label>
				<select name="debet[coa_id]" class="rekening">
					<option value="0">-- Pilih Rekening --</option>
					<?php echo $this->Form->drop_down_entry($coas, array('default' => isset($InvoiceCreate_debet['coa_id']) ? $InvoiceCreate_debet['coa_id'] : NULL) );?>
				</select>
				<label>Nama/Keterangan Transaksi</label>
				<textarea name="debet[nama_transaksi]" style="width: 90%; height: 120px;"><?php echo isset($InvoiceCreate_debet['nama_transaksi']) ? $InvoiceCreate_debet['nama_transaksi'] : NULL;?></textarea>		    				
			</div>
			<!-- Tax -->
			<?php $Invoice_Tax_Debet = $this->Jurnal->getTaxConfig($InvoiceCreate['JurnalConfig'],'debet');?>
			<label class="checkbox"><input value="1" onclick="toggleTax(this);" type="checkbox" name="debet[use_tax][on]" <?php echo (is_array($Invoice_Tax_Debet))? 'checked="checked"': '';?>>Use Tax?</label>	    					    		
			<div class="jurnal-container" <?php echo (is_array($Invoice_Tax_Debet)) ? '' : 'style="display:none;"';?>>		
				<label>Rekening</label>
				<select name="debet[use_tax][coa_id]" class="rekening">
					<option value="0">-- Pilih Rekening --</option>
					<?php echo $this->Form->drop_down_entry($coas, array('default' => isset($InvoiceCreate_debet['tax_coa']) ? $InvoiceCreate_debet['tax_coa'] : NULL) );?>
				</select>  				
				<h4>Pajak</h4>
				<input type="hidden" name="debet[tax][id]" value="<?php echo isset($Invoice_Tax_Debet) ? $Invoice_Tax_Debet['id'] : NULL;?>" style="display:inline;">			    			    			
				<div class="jurnal-content">
					<label>Rekening</label>
					<select name="debet[tax][coa_id]" class="rekening">
						<option value="0">-- Pilih Rekening --</option>
						<?php echo $this->Form->drop_down_entry($coas,array('default' => isset($Invoice_Tax_Debet) ?$Invoice_Tax_Debet['coa_id'] : NULL));?>
					</select>	
					<label>Nama/Keterangan Transaksi</label>
					<textarea name="debet[tax][nama_transaksi]" style="width: 90%; height: 90px;"><?php echo isset($Invoice_Tax_Debet) ? $Invoice_Tax_Debet['nama_transaksi'] : NULL;?></textarea>		    							    						    				    				
				</div>		    			
			</div>	
		</div>		    		
	</div>
	<!-- END SendPO Debet Block -->
	<!-- SendPO KREDIT Block -->
	<div class="col-sm-">
		<h4>Kredit</h4>
		<input type="hidden" name="kredit[id]" value="<?php echo isset($InvoiceCreate_kredit['id']) ? $InvoiceCreate_kredit['id'] : NULL;?>" style="display:inline;">		    		
		<div class="jurnal-container">
			<div class="jurnal-content">
				<label>Rekening</label>
				<select name="kredit[coa_id]" class="rekening">
					<option value="0">-- Pilih Rekening --</option>
					<?php echo $this->Form->drop_down_entry($coas,array('default' => isset($InvoiceCreate_kredit['coa_id']) ? $InvoiceCreate_kredit['coa_id'] : NULL));?>
				</select>	
				<label>Nama/Keterangan Transaksi</label>
				<textarea name="kredit[nama_transaksi]" style="width: 90%; height: 120px;"><?php echo isset($InvoiceCreate_kredit['nama_transaksi']) ? $InvoiceCreate_kredit['nama_transaksi'] : NULL;?></textarea>		    							    						    				    				
			</div>
			<!-- Tax -->
			<?php $Invoice_Tax_Kredit = $this->Jurnal->getTaxConfig($InvoiceCreate['JurnalConfig'],'kredit');?>
			<label class="checkbox"><input value="1" onclick="toggleTax(this);" type="checkbox" name="kredit[use_tax][on]" <?php echo (is_array($Invoice_Tax_Kredit))? 'checked="checked"': '';?>>Use Tax?</label>	    					    		
			<div class="jurnal-container" <?php echo (is_array($Invoice_Tax_Kredit)) ? '' : 'style="display:none;"';?>>		
				<label>Rekening</label>
				<select name="kredit[use_tax][coa_id]" class="rekening">
					<option value="0">-- Pilih Rekening --</option>
					<?php echo $this->Form->drop_down_entry($coas, array('default' => isset($InvoiceCreate_kredit['tax_coa']) ? $InvoiceCreate_kredit['tax_coa'] : NULL) );?>
				</select>  				
				<h4>Pajak</h4>
				<input type="hidden" name="kredit[tax][id]" value="<?php echo isset($Invoice_Tax_Kredit) ? $Invoice_Tax_Kredit['id'] : NULL;?>" style="display:inline;">			    			    			
				<div class="jurnal-content">
					<label>Rekening</label>
					<select name="kredit[tax][coa_id]" class="rekening">
						<option value="0">-- Pilih Rekening --</option>
						<?php echo $this->Form->drop_down_entry($coas,array('default' => isset($Invoice_Tax_Kredit) ?$Invoice_Tax_Kredit['coa_id'] : NULL));?>
					</select>	
					<label>Nama/Keterangan Transaksi</label>
					<textarea name="kredit[tax][nama_transaksi]" style="width: 90%; height: 90px;"><?php echo isset($Invoice_Tax_Kredit) ? $Invoice_Tax_Kredit['nama_transaksi'] : NULL;?></textarea>		    							    						    				    				
				</div>		    			
			</div>		    			
		</div>		 	  
		<button type="submit" class="btn btn-success pull-right">Submit</button>  		   		    		
	</div>
	<!-- END SendPO KREDIT Block -->	    			    		    			    			    	
</form>