<a class="help" onclick="togglePoHelp();" href="javascript:void(0);" data-toggle="tooltip" title="available twig markup eg: {{PO.nama_pemilik}}"><i class="icon-question-sign"></i></a>	    	
<div id="help_po" style="background-color:#F9F9F9;display:none;">
<?php 
echo <<<'EOD'
PO.order_id<br>
PO.supplier_id<br>
PO.user_id<br>
PO.path<br>
PO.sent_at<br>
PO.created<br>
PO.supplier_invoice<br> 
PO.outpayment_id<br>
PO.pre_checker<br>
PO.today_checker<br>
PO.shipped_date<br>
PO.date_changed_by<br>
PO.arival_office_date<br>
PO.ekspedisi_date<br>
PO.total<br>
PO.nama_supplier<br>
PO.nama_pemilik<br> 
Current_Date
EOD;
?>	  		
</div>	    	
<?php 
	$SendPO = $this->Array->Get($configs,'SEND_PO');
	$SendPO_Extra = json_decode($SendPO['Jconfig']['extra'],TRUE);	
	$SendPO_cfg = ( !empty($SendPO) ) ? $SendPO['Jconfig'] : array();
	$SendPO_Debet = $this->Jurnal->getConfig($SendPO['JurnalConfig'],'debet');
	$SendPO_Kredit = $this->Jurnal->getConfig($SendPO['JurnalConfig'],'kredit');
?>
<form id="fmSendPo" class="jurnal_config" method="POST" action="<?php echo $this->webroot;?>jurnalconfigs/save">	    			
	<input type="hidden" name="main_id" value="<?php echo $this->Array->Get($SendPO_cfg,'id',1);?>">
	<table class="table table-striped table-bordered">
		<tr>
			<td style="width:10%;"><label class="control-label">Entry Date</label></td>
			<td><input style="width:75%;" type="text" name="extra[entry_date]"" value="<?php echo $this->Array->Get($SendPO_Extra,'entry_date');?>"></td>
		</tr>		
		<tr>
			<td style="width:10%;"><label class="control-label">Voucher Number</label></td>
			<td><input style="width:75%;" type="text" name="voucher_number" value="<?php echo $SendPO_cfg['voucher_number'];?>"></td>
		</tr>
    	<tr>
    		<td style="width:10%;"><label class="control-label">Nama Transaksi</label></td>	    			
			<td><input style="width:75%;" type="text" name="nama_transaksi" value="<?php echo $SendPO_cfg['nama_transaksi'];?>"></td>
		</tr>
	</table>
	<div class="clearfix"></div>
	<!-- SendPO DEBET Block -->
	<div class="span5">	    		
		<h4>Debet</h4>
		<input type="hidden" name="debet[id]" value="<?php echo isset($SendPO_Debet['id']) ? $SendPO_Debet['id'] : NULL;?>" style="display:inline;">
		<div class="jurnal-container">
			<div class="jurnal-content">
				<label>Rekening</label>
				<select name="debet[coa_id]" class="rekening">
					<option value="0">-- Pilih Rekening --</option>
					<?php echo $this->Form->drop_down_entry($coas, array('default' => isset($SendPO_Debet['coa_id']) ? $SendPO_Debet['coa_id'] : NULL) );?>
				</select>
				<label>Nama/Keterangan Transaksi</label>
				<textarea name="debet[nama_transaksi]" style="width: 90%; height: 120px;"><?php echo isset($SendPO_Debet['nama_transaksi']) ? $SendPO_Debet['nama_transaksi'] : NULL;?></textarea>		    				
			</div>
			<!-- Tax -->
			<?php $SendPO_Tax_Debet = $this->Jurnal->getTaxConfig($SendPO['JurnalConfig'],'debet');?>
			<label class="checkbox"><input value="1" onclick="toggleTax(this);" type="checkbox" name="debet[use_tax][on]" <?php echo (is_array($SendPO_Tax_Debet))? 'checked="checked"': '';?>>Use Tax?</label>	    					    		
    		<div class="jurnal-container" <?php echo (is_array($SendPO_Tax_Debet)) ? '' : 'style="display:none;"';?>>		
				<label>Rekening</label>
				<select name="debet[use_tax][coa_id]" class="rekening">
					<option value="0">-- Pilih Rekening --</option>
					<?php echo $this->Form->drop_down_entry($coas, array('default' => isset($SendPO_Debet['tax_coa']) ? $SendPO_Debet['tax_coa'] : NULL) );?>
				</select>    			  			
    			<h4>Pajak</h4>
    			<input type="hidden" name="debet[tax][id]" value="<?php echo isset($SendPO_Tax_Debet) ? $SendPO_Tax_Debet['id'] : NULL;?>" style="display:inline;">			    			    			
    			<div class="jurnal-content">
    				<label>Rekening</label>
    				<select name="debet[tax][coa_id]" class="rekening">
    					<option value="0">-- Pilih Rekening --</option>
    					<?php echo $this->Form->drop_down_entry($coas,array('default' => isset($SendPO_Tax_Debet) ?$SendPO_Tax_Debet['coa_id'] : NULL));?>
    				</select>	
    				<label>Nama/Keterangan Transaksi</label>
    				<textarea name="debet[tax][nama_transaksi]" style="width: 90%; height: 90px;"><?php echo isset($SendPO_Tax_Debet) ? $SendPO_Tax_Debet['nama_transaksi'] : NULL;?></textarea>		    							    						    				    				
    			</div>		    			
    		</div>	
		</div>		    		
	</div>
	<!-- END SendPO Debet Block -->
	<!-- SendPO KREDIT Block -->
	<div class="col-sm-">
		<h4>Kredit</h4>
		<input type="hidden" name="kredit[id]" value="<?php echo isset($SendPO_Kredit['id']) ? $SendPO_Kredit['id'] : NULL;?>" style="display:inline;">		    		
		<div class="jurnal-container">
			<div class="jurnal-content">
				<label>Rekening</label>
				<select name="kredit[coa_id]" class="rekening">
					<option value="0">-- Pilih Rekening --</option>
					<?php echo $this->Form->drop_down_entry($coas,array('default' => isset($SendPO_Kredit['id']) ? $SendPO_Kredit['coa_id'] : NULL));?>
				</select>	
				<label>Nama/Keterangan Transaksi</label>
				<textarea name="kredit[nama_transaksi]" style="width: 90%; height: 120px;"><?php echo isset($SendPO_Kredit['nama_transaksi']) ? $SendPO_Kredit['nama_transaksi'] : NULL;?></textarea>		    							    						    				    				
			</div>
			<!-- Tax -->
			<?php $SendPO_Tax_Kredit = $this->Jurnal->getTaxConfig($SendPO['JurnalConfig'],'kredit');?>
			<label class="checkbox"><input value="1" onclick="toggleTax(this);" type="checkbox" name="kredit[use_tax][on]" <?php echo (is_array($SendPO_Tax_Kredit))? 'checked="checked"': '';?>>Use Tax?</label>	    					    		
    		<div class="jurnal-container" <?php echo (is_array($SendPO_Tax_Kredit)) ? '' : 'style="display:none;"';?>>		
				<label>Rekening</label>
				<select name="kredit[use_tax][coa_id]" class="rekening">
					<option value="0">-- Pilih Rekening --</option>
					<?php echo $this->Form->drop_down_entry($coas, array('default' => isset($SendPO_Kredit['tax_coa']) ? $SendPO_Kredit['tax_coa'] : NULL) );?>
				</select>        			
    			<h4>Pajak</h4>
    			<input type="hidden" name="kredit[tax][id]" value="<?php echo isset($SendPO_Tax_Kredit) ? $SendPO_Tax_Kredit['id'] : NULL;?>" style="display:inline;">			    			    			
    			<div class="jurnal-content">
    				<label>Rekening</label>
    				<select name="kredit[tax][coa_id]" class="rekening">
    					<option value="0">-- Pilih Rekening --</option>
    					<?php echo $this->Form->drop_down_entry($coas,array('default' => isset($SendPO_Tax_Kredit) ?$SendPO_Tax_Kredit['coa_id'] : NULL));?>
    				</select>	
    				<label>Nama/Keterangan Transaksi</label>
    				<textarea name="kredit[tax][nama_transaksi]" style="width: 90%; height: 90px;"><?php echo isset($SendPO_Tax_Kredit) ? $SendPO_Tax_Kredit['nama_transaksi'] : NULL;?></textarea>		    							    						    				    				
    			</div>		    			
    		</div>		    			
		</div>		 	    		   		    		
		<button type="submit" class="btn btn-success pull-right">Submit</button>
	</div>
	<!-- END SendPO KREDIT Block -->	    			    		    	
</form>