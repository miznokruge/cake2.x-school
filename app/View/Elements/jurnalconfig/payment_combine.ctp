<!-- alias of PaymentCombine -->
<a class="help" onclick="toggleHelpPayment();" href="javascript:void(0);" data-toggle="tooltip" title="available twig markup. eg : {{Payment.trans_code}}"><i class="icon-question-sign"></i></a>	    	
<div id="help_payment" style="background-color:#F9F9F9;display:none;">
<?php 
echo <<<'EOD'
    Outpayment.id<br>
    Outpayment.bukti_transfer<br>
    Outpayment.paid<br>
    Outpayment.created<br>
    Outpayment.bank<br>
    Outpayment.path<br>
    Outpayment.trans_code<br>
    Supplier.name<br>
    Po.path<br>
    Outpayment.paths<br>
    Current_Date
EOD;
?>	    	
</div>
<?php 
	$PaymentCombine = $this->Array->Get($configs,'PAYMENT_COMBINE',array());
	$PaymentCombine_Extra = json_decode($PaymentCombine['Jconfig']['extra'],TRUE);	
	$PaymentCombine_cfg = ( !empty($PaymentCombine) ) ? $PaymentCombine['Jconfig'] : array();
	$PaymentCombine_Debet = $this->Jurnal->getConfig($PaymentCombine['JurnalConfig'],'debet');
	$PaymentCombine_Kredit = $this->Jurnal->getConfig($PaymentCombine['JurnalConfig'],'kredit');
?>	    	
<form id="fmPaymentCombine" class="jurnal_config" method="POST" action="<?php echo $this->webroot;?>jurnalconfigs/save">    		
	<input type="hidden" name="main_id" value="<?php echo $this->Array->Get($PaymentCombine_cfg,'id',6);?>">
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
				<?php if($bank['Bank']['bank_type'] === 'in'){continue;}?>
				<tr>
					<td style="width:10%;">
						<input type="hidden" name="bank[name][]" value="<?php echo $bank['Bank']['short_name'];?>">
						<label class="control-label"><?php echo $bank['Bank']['nama_bank'];?></label>
					</td>
		    		<td style="width:10%;">
		    			<select name="bank[akun][]" class="rekening">
		    				<option value="0">-- Pilih Rekening --</option>
		    				<?php echo $this->Form->drop_down_entry($coas,array('default' => $PaymentCombine_Bank['banks'][ $bank['Bank']['short_name'] ]));?>
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
			<td><input style="width:75%;" type="text" name="extra[entry_date]"" value="<?php echo $this->Array->Get($PaymentCombine_Extra,'entry_date');?>"></td>
		</tr>		
		<tr>
			<td style="width:10%;"><label class="control-label">Voucher Number</label></td>
			<td><input style="width:75%;" type="text" name="voucher_number" value="<?php echo $PaymentCombine_cfg['voucher_number'];?>"></td>
		</tr>
    	<tr>
    		<td style="width:10%;"><label class="control-label">Nama Transaksi</label></td>	    			
			<td><input style="width:75%;" type="text" name="nama_transaksi" value="<?php echo $PaymentCombine_cfg['nama_transaksi'];?>"></td>
		</tr>
	</table> 	
	<!-- PaymentCreate DEBET Block -->
	<div class="span5">
		<h4>Debet</h4>
		<input type="hidden" name="debet[id]" value="<?php echo isset($PaymentCombine_Debet['id']) ? $PaymentCombine_Debet['id'] : NULL;?>" style="display:inline;">		    		
		<label class="checkbox"><input type="radio" name="use_bank" value="debet" <?php echo ($PaymentCombine_Bank['use_bank'] == 'debet') ? 'checked="checked"' : '';?>>Use Bank Account</label>		
		<div class="jurnal-container">	    			
			<div class="jurnal-content">
				<label>Rekening</label>
				<select name="debet[coa_id]" class="rekening">
					<?php echo $this->Form->drop_down_entry($coas,array('default' => isset($PaymentCombine_Debet['coa_id']) ? $PaymentCombine_Debet['coa_id'] : NULL));?>
				</select>
				<label>Nama/Keterangan Transaksi</label>
				<textarea name="debet[nama_transaksi]" style="width: 90%; height: 120px;"><?php echo isset($PaymentCombine_Debet['nama_transaksi']) ? $PaymentCombine_Debet['nama_transaksi'] : NULL;?></textarea>		    							    				
			</div>	 
			<div class="jurnal-container">	
				<h4>Pajak</h4>
				<label>Rekening</label>
				<select name="debet[use_tax][coa_id]" class="rekening">
					<option value="0">-- Pilih Rekening --</option>
					<?php echo $this->Form->drop_down_entry($coas, array('default' => isset($PaymentCombine_Debet['tax_coa']) ? $PaymentCombine_Debet['tax_coa'] : NULL) );?>
				</select> 	
			</div>		   			
		</div>				
	</div>
	<!-- END PaymentCreate DEBET Block -->
	<!-- PaymentCreate KREDIT Block -->
	<div class="col-sm-">
		<h4>Kredit</h4>
		<input type="hidden" name="kredit[id]" value="<?php echo isset($PaymentCombine_Kredit['id']) ? $PaymentCombine_Kredit['id'] : NULL;?>" style="display:inline;">		    		
		<label class="checkbox"><input type="radio" name="use_bank" value="kredit" <?php echo ($PaymentCombine_Bank['use_bank'] == 'kredit') ? 'checked="checked"' : '';?>>Use Bank Account</label>		
		<div class="jurnal-container">			
			<div class="jurnal-content">		    			
				<label>Rekening</label>
				<select name="kredit[coa_id]" class="rekening">
					<?php echo $this->Form->drop_down_entry($coas,array('default' => isset($PaymentCombine_Kredit['coa_id']) ? $PaymentCombine_Kredit['coa_id'] : NULL));?>
				</select>	
				<label>Nama/Keterangan Transaksi</label>
				<textarea name="kredit[nama_transaksi]" style="width: 90%; height: 120px;"><?php echo isset($PaymentCombine_Kredit['nama_transaksi']) ? $PaymentCombine_Kredit['nama_transaksi'] : NULL;?></textarea>		    							    						    				    				
			</div>	
			<div class="jurnal-container">	
				<h4>Pajak</h4>
				<label>Rekening</label>
				<select name="kredit[use_tax][coa_id]" class="rekening">
					<option value="0">-- Pilih Rekening --</option>
					<?php echo $this->Form->drop_down_entry($coas, array('default' => isset($PaymentCombine_Kredit['tax_coa']) ? $PaymentCombine_Kredit['tax_coa'] : NULL) );?>
				</select>  		
			</div>							
		</div>								    			
		<button type="submit" class="btn btn-success pull-right">Submit</button>   		    		
	</div>
	<!-- END PaymentCreate KREDIT Block -->		    		    	
</form>