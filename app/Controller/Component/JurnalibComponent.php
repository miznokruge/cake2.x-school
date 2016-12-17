<?php
/**
* Jurnal specific Component
*/
class JurnalibComponent extends Component
{
	//default template for entry date
	CONST ENTRY_DATE_TPL = '{{Current_Date}}';
	//map
	public $Rules = array(
		'SEND_PO',
		'LUNAS_KIRIM',
		'INVOICE_CREATE',
		'CHECKORDER_INVOICE',
		'WAIT_PAYMENT', //terima DP
		'PAYMENT_COMBINE'
	);
	
    public $components = array('Acl','Util',
        'Auth' => array(
            'authorize' => array(
                'Actions' => array('actionPath' => 'controllers')
            )
        ),'Arr','Twig'); 	
		
	public function arrayToBankMap(array $sources,array $extra)
	{
		$result = array('type' => 'bank');
		foreach( $sources['name'] as $idx=>$src )
		{
			$result['banks'][$src] = $sources['akun'][$idx];
		}
		
		foreach( $extra as $key=>$ext )
		{
			$result[$key] = $ext;
		}
		
		$result['use_bank'] = $sources['use_bank'];
		return $result;
	}
	
	//fill JurnalDetail with JurnalID
	protected function fillJurnalId(array $dirty,$jurnalID)
	{
		$result = array();
		foreach($dirty as $dt)
		{
			$dt['jurnal_id'] = $jurnalID;
			$result[] = $dt;					
		}
		
		return $result;
	}
	
	protected function calculateTax($value)
	{
		return ceil(floatval($value) / 1.1);	
	}
	
	//validate save
	protected function isValidInput($post,$convert = TRUE)
	{				
		$tanggal_masuk = date('Y-m-d H:i:s',time());
		if( $convert === TRUE )
			$data = $this->Util->toSaveableArray( $post );
		else		
		    $data = $post;	
				
		$kredit = 0;
		$debet = 0;
		foreach( $data as $idx=>$dt )
		{
			if( !$this->Util->isDecimal($dt['debit']) )			
				$tmpDebet = $this->Util->filterPrice($dt['debit']);
			else 
				$tmpDebet = $dt['debit'];
			
			
			if( !$this->Util->isDecimal($dt['kredit']) )	
				$tmpKredit = $this->Util->filterPrice($dt['kredit']);
			else
				$tmpKredit = $dt['kredit'];
			
			if((int)$tmpDebet === 0 && (int)$tmpKredit === 0){
				unset($data[$idx]);
				continue;
			}
												
			if( !is_numeric(trim( $dt['coa_id'] )) ){
				throw new ErrorException('rekening tidak valid.');
			}
			
			print_r($tmpKredit);
			$kredit += floatVal( $tmpKredit );
			$debet  += floatVal( $tmpDebet);					
		}

		if( $kredit !== $debet ){
			throw new ErrorException('Ooops..Debet dan Kredit tidak sesuai silahkan periksa kembali.<br>Debet : '.number_format($debet).' - Kredit : '.number_format($kredit));
		}
		
		$data['jumlah'] = $debet;
		return $data;
	}	

	/*@ sources : config sources
	 *@ bank_name : short name of bank
	*/
	protected function getAkunByBank(array $sources,$bank_name)
	{
		return $this->Arr->Get($sources['banks'],$bank_name);
	}
	
	public function normalizeInput($post,&$parent){
		$parent['jurnal_id'] = $this->Arr->Get($post,'jurnal_id');
		$parent['voucher_number'] = $this->Arr->Get($post,'voucher_number');
		//$parent['keterangan_transaksi'] = $this->Arr->Get($post,'keterangan_transaksi');
		$parent['nama_transaksi'] = $this->Arr->Get($post,'nama_transaksi');	
		unset($post['voucher_number']);unset($post['keterangan_transaksi']);unset($post['nama_transaksi']);unset($post['jurnal_id']);
		
		$tmp = $this->Util->toSaveableArray( $post );
		$result = array();
		foreach($tmp  as $idx=>$tp){
			$tp['kredit'] = $this->Util->filterPrice($tp['kredit']);
			$tp['debit'] = $this->Util->filterPrice($tp['debit']);
			$result[] = $tp;
		}
		
		unset($tmp);
		return $result;
	}
	
	public function save($post,$convert = TRUE)
	{
		$Jurnal = ClassRegistry::init('Jurnal');
		$JurnalDetail = ClassRegistry::init('JurnalDetail');
		
		$voucher_number = $this->Arr->Get($post,'voucher_number');
		$nama_transaksi = $this->Arr->Get($post,'nama_transaksi');
		$tanggal_entry = $this->Arr->Get($post,'tanggal_entry', date('Y-m-d H:i:s',time()) );
		
		if( $this->Arr->Get($post,'tanggal_entry') )
			unset($post['tanggal_entry']);
		
		$jurnalID = $this->Arr->Get($post,'jurnal_id');
		
		if( empty($voucher_number) ){
			throw new ErrorException('Ooops..Kode voucher harus diisi.');
		}
		if( empty($nama_transaksi) ){
			throw new ErrorException('Ooops..Nama Transaksi harus diisi.');
		}
		
		unset($post['voucher_number']);
		//unset($post['keterangan_transaksi']);
		unset($post['nama_transaksi']);
		unset($post['jurnal_id']);
						
		$tmp = $this->isValidInput($post,$convert);
		
		$jurnalData = array();
		if( is_numeric($jurnalID) ){
			$jurnalData['id'] = $jurnalID;
		}	
		$jurnalData['voucher_number'] = $voucher_number;
		$jurnalData['nama_transaksi'] = $nama_transaksi;
		//$jurnalData['keterangan_transaksi'] = $keterangan;
		$jurnalData['tanggal_entry'] = $tanggal_entry;
		$jurnalData['jumlah'] = $tmp['jumlah'];
		$jurnalData['user_id'] = $this->UserAuth->user('id');				
		
		if( $Jurnal->save($jurnalData) )
		{
			unset($tmp['jumlah']);
			$clean_data = $this->fillJurnalId($tmp,$Jurnal->id);
			
			$JurnalDetail->saveMany($clean_data);
			$Jurnal->id = NULL;
			$JurnalDetail->id = NULL;
		}else{
			throw new ErrorException( $this->Util->validationErrorsToStr($Jurnal->validationErrors) );
		}		
	}	

	public function splitConfig($configs)
	{
		$response = array();
		foreach( $configs as $con )
		{	
			$response[ $this->Rules[ (int)$con['Jconfig']['id'] - 1 ] ] = $con;				
		}
		
		return $response;
	}
	
	/*
	 * @type : it can be debet or kredit
	 * @configs : the sources of configs
	 */
	protected function getConfigType($type,$configs){		
		foreach( $configs as $c ){
			if( (int)$c['config_type'] === 0 && strtolower($c['jurnal_type']) == strtolower($type) )
			 return $c;
		}
	} 
	
	protected function getPrimaryConfig($source){
		return $source['Jconfig'];
	} 	
	


	//handle SEND_PO accounting automation
	public function createPOJurnal($orderID,$pos,$order)
	{
		//pull config for SEND_PO
		$config = ClassRegistry::init('Jconfig');
		$entry_config = $config->read(NULL,1);			
		if( count($entry_config) <= 0 )return false;
		
				
		if( is_numeric($orderID) )
		{
			//group PO by supplier_id
			$spo = array();
			foreach( $pos as $p )
			{
				$p['Po']['total'] = 0;
				$spo[$p['Po']['supplier_id']] = $p['Po'];
			}
			unset($pos);
			
			$buy = ClassRegistry::init('Buy');
			
			$buys = $buy->find('all',array('conditions' => array('order_id' => $orderID)));
			//sum
			foreach( $buys as $b )
			{				
				if( $this->Arr->Get($spo,$b['Buy']['supplier_id']) )
				{
					$tmp_total = floatval($b['Buy']['list_price']) * (int)$b['Buy']['qty'];	
					//calculate discount				
					$discount = ( floatval($tmp_total) * floatval($b['Buy']['supplier_discount']) ) / 100;
					$spo[ $b['Buy']['supplier_id'] ]['total'] = $tmp_total - $discount;													
					$spo[ $b['Buy']['supplier_id'] ]['nama_supplier'] = $b['Supplier']['name'];
					$spo[ $b['Buy']['supplier_id'] ]['nama_pemilik'] = $b['Supplier']['account_name'];
					$spo[ $b['Buy']['supplier_id'] ]['nama_pt'] = $b['Supplier']['nama_pt'];										
				}			
			}
			
			$main_config = $this->getPrimaryConfig($entry_config);
			$response = array();
			$extra_config = json_decode($main_config['extra'],TRUE);
						
			//template for entry date
			$tpl_entry_date = $this->Arr->Get($extra_config,'entry_date',self::ENTRY_DATE_TPL);
			if( $tpl_entry_date  === self::ENTRY_DATE_TPL ){
				$tanggal_entry =  date('Y-m-d H:i:s',time());
			}else{				
				$tanggal_entry =  $this->Twig->render($tpl_entry_date,array('PO'=>$p));
			}						
					
			foreach( $spo as $p )
			{											
				$v_number = explode('-',$p['path']);
				if( count($v_number) === 3 ){
					$p['path'] = $v_number[0].'/'.substr($v_number[1], 0,3).'/'.substr($v_number[2], 2,2);
				}				

				$tmp = array(
					'tanggal_entry' => $tanggal_entry,
					'voucher_number' => $this->Twig->render($main_config['voucher_number'],array('PO'=>$p)),
					'nama_transaksi' =>  $this->Twig->render($main_config['nama_transaksi'],array('PO'=>$p)),
					'jumlah' => $p['total'],
					'PO' => $p
				);				

				if( (int)$order['use_tax'] === 1 ){
					$nama_transaksi = 'PO '.$v_number[0].' - '.$this->Arr->Get($p,'nama_pt');
					$response['use_tax'] =  TRUE;
				}
				else{
					$nama_transaksi = 'PO '.$v_number[0].' - '.$this->Arr->Get($p,'nama_pemilik');
					$response['use_tax'] = FALSE;
				}
				
				$response[] = $tmp;	
			}		
			
			$tax_config = $this->getTaxConfig($entry_config['JurnalConfig']);
			
			foreach( $response as $r )
			{			
				if( !is_array($r) ) continue;
				$data_jurnal = array(
					'tanggal_entry' => $r['tanggal_entry'],
					'voucher_number' => $r['voucher_number'],
					'nama_transaksi' => $r['nama_transaksi'],						
				);					
									
				foreach( $entry_config['JurnalConfig'] as $idx=>$ec )
				{
					$po_data = array('PO' => $r['PO']);
					if( (int)$ec['config_type'] === 1 ){ continue; }
									
					if( $ec['jurnal_type'] == 'debet' )
					{
						if( $response['use_tax'] === TRUE && is_array($tax_config) )
						{
							$tax_index = $tax_config['index'];
							$jml = $r['jumlah'];								
							$jml = $this->calculateTax($jml);								
							$tax_value = floatval($r['jumlah']) - floatval($jml);
							
							if( $tax_config['config']['jurnal_type'] === 'debet' ){
								$data_jurnal[ $tax_index ]['kredit'] = 0;
								$data_jurnal[ $tax_index ]['debit'] = $tax_value;
								$data_jurnal[$idx]['debit'] = $jml;					
							}else{
								$data_jurnal[$idx]['debit'] = $r['jumlah'];
							}							

							$ec['coa_id'] = $ec['tax_coa'];
							$data_jurnal[ $tax_index ]['keterangan'] = $this->Twig->render($tax_config['config']['nama_transaksi'],$po_data);
							$data_jurnal[ $tax_index ]['coa_id'] = $tax_config['config']['coa_id'];																										
						}else{
							 $data_jurnal[$idx]['debit'] = $r['jumlah'];
						}							
												
						$data_jurnal[$idx]['kredit'] = 0;	
					}
					elseif( $ec['jurnal_type'] == 'kredit' )
					{
						if( $response['use_tax'] === TRUE && is_array($tax_config) )
						{
							$tax_index = $tax_config['index'];
							$jml = $r['jumlah'];								
							$jml = $this->calculateTax($jml);								
							$tax_value = floatval($r['jumlah']) - floatval($jml);
							
							if( $tax_config['config']['jurnal_type'] === 'kredit' ){
								$data_jurnal[ $tax_index ]['kredit'] = $tax_value;
								$data_jurnal[ $tax_index ]['debet'] = 0;
								$data_jurnal[$idx]['kredit'] = $jml;							
							}
							else{
								$data_jurnal[$idx]['kredit'] = $r['jumlah'];
							}						
							
							$ec['coa_id'] = $ec['tax_coa'];
							$data_jurnal[ $tax_index ]['keterangan'] = $this->Twig->render($tax_config['config']['nama_transaksi'],$po_data);
							$data_jurnal[ $tax_index ]['coa_id'] = $tax_config['config']['coa_id'];
						}else{ $data_jurnal[$idx]['kredit'] = $r['jumlah']; }					
						
						$data_jurnal[$idx]['debit'] = 0;	
					}			
					
					$data_jurnal[$idx]['coa_id'] = $ec['coa_id'];	
					$data_jurnal[$idx]['keterangan'] = $this->Twig->render($ec['nama_transaksi'],$po_data);															
				}							
				unset($r['PO']);	
				$this->save($data_jurnal,FALSE);	
			}

		}else{ throw new InvalidArgumentException(); }
	}

	//payment combine
	protected function calculatePayment($source)
	{
		$total = 0;
		foreach( $source as $src )
		{
			$total += ($src['os']['buy_price'] + $src['ship']['buy_price']) - $src['os']['dp'];
		}
		
		return $total;
	}
	
	/*
	 * Rule Kredit mempunyai banyak debet 
	*/
	public function createPaymentCombine($payments,$out_id)
	{	
		//pull config
		$config = ClassRegistry::init('Jconfig');
		$entry_config = $config->read(NULL,6);
		if( count($entry_config) <= 0) return FALSE;
		
		$Outpayment = ClassRegistry::init('Outpayment');	
		$outpayment = $Outpayment->read(NULL,$out_id);

		$total = $this->Arr->Get($payments,'total',$this->calculatePayment($payments));

		$bankAccount = json_decode($entry_config['Jconfig']['extra'],TRUE);
		$akun_bank = $this->getAkunByBank($bankAccount, $outpayment['Outpayment']['bank']);
		
		$main_config = $this->getPrimaryConfig($entry_config);
					
		//template for entry date
		$tpl_entry_date = $this->Arr->Get($bankAccount,'entry_date',self::ENTRY_DATE_TPL);
		if( $tpl_entry_date  === self::ENTRY_DATE_TPL ){
			$tanggal_entry =  date('Y-m-d H:i:s',time());
		}else{				
			$tanggal_entry =  $this->Twig->render($tpl_entry_date,$outpayment);
		}	
	
		//pull tax config
		$tax_config = $this->getTaxConfig($entry_config['JurnalConfig']);
		
		$response = array(
			'tanggal_entry'		=>	$tanggal_entry,
		);			
		
		$debet_config = $this->getConfigType('debet', $entry_config['JurnalConfig']);
		$kredit_config = $this->getConfigType('kredit', $entry_config['JurnalConfig']);
		$po_paths = array();
				
		foreach( $payments as $idx=>$payment )
		{				
			$po_paths[] = $this->Util->getPOPath( $payment['Po']['path'],TRUE );
			$outpayment['Po']['path'] = $this->Util->getPOPath($payment['Po']['path']);
			
			$response[$idx + 1]['kredit'] = 0;
			$response[$idx + 1]['debit'] = ($payment['os']['buy_price'] + $payment['ship']['buy_price']) - $payment['os']['dp'];
			
			if( $bankAccount['use_bank'] === 'debet' ){
				$response[$idx + 1]['coa_id'] = $akun_bank;
			}elseif( (int)$debet_config['tax_coa'] > 0 ){
				$response[$idx + 1]['coa_id'] = $debet_config['tax_coa'];
			}else{
				$response[$idx + 1]['coa_id'] = $debet_config['coa_id'];
			}
			
			$response[$idx + 1]['keterangan'] = $this->Twig->render( $debet_config['nama_transaksi'],$outpayment );		
		}

		$outpayment['Supplier']['name'] = $payments[0]['sup']['name'];		
		$outpayment['Outpayment']['paths'] = implode(',',$po_paths);
		
		$response['voucher_number'] = $this->Twig->render($main_config['voucher_number'],$outpayment);
		$response['nama_transaksi'] = $this->Twig->render($main_config['nama_transaksi'],$outpayment);
		
		$response[0]['kredit'] = $total;
		$response[0]['debit'] = 0;
		if( $bankAccount['use_bank'] === 'kredit' ){
			$response[0]['coa_id'] = $akun_bank;
		}else{
			$response[0]['coa_id'] = $kredit_config['coa_id'];
		}
			
		$response[0]['keterangan'] = $this->Twig->render( $kredit_config['nama_transaksi'],$outpayment );	
							
		$this->save($response,FALSE);		
	}

	//lunas kirim
	public function createLunasKirimJurnal($payment_orderID,$payment)
	{
		$Order = ClassRegistry::init('Order');
		$Order->unbindAll();
		$Order->bindModel( array('belongsTo' => array('Customer') ));
		$order = $Order->read(NULL,$payment['PaymentOrder']['order_id']);
		$use_tax = $order['Order']['use_tax'];
		$customer = $order['Customer'];
		unset($order);
		//pull config
		$config = ClassRegistry::init('Jconfig');
		$entry_config = $config->read(NULL,2);
		if( count($entry_config)  <= 0) return FALSE;
	
		$bankAccount = json_decode($entry_config['Jconfig']['extra'],TRUE);
		$main_config = $this->getPrimaryConfig($entry_config);		
	
		$twig_data = array('PaymentOrder' => $payment['PaymentOrder'],'Customer' => $customer);	

		//template for entry date
		$tpl_entry_date = $this->Arr->Get($bankAccount,'entry_date',self::ENTRY_DATE_TPL);
		if( $tpl_entry_date  === self::ENTRY_DATE_TPL ){
			$tanggal_entry =  date('Y-m-d H:i:s',time());
		}else{				
			$tanggal_entry =  $this->Twig->render($tpl_entry_date,$twig_data);
		}	
		
		$Invoice = ClassRegistry::init('Invoice');
		$result_invoice = $Invoice->find('all',array(
			'conditions' => array(
				'Invoice.order_id' => $payment['PaymentOrder']['order_id']
			)
		));
		
		$invoice = NULL;
		foreach( $result_invoice as $inv )
		{
			if( strtoupper(substr($inv['Invoice']['path'],0,1)) === 'L' ){
				$invoice = $inv['Invoice'];
				break;
			}
		}
		
		if( $invoice )
		{
			$invoice_code = $this->getInvoiceCode($invoice['path'],TRUE);
			$twig_data['Invoice']['InvoiceID'] = $invoice_code;
		}
		else
		{
			//kasus jika invoice Lunas tidak ditemukan
			$twig_data['Invoice']['InvoiceID'] = 'NULL';
		}

		$response = array(
			'voucher_number' => $this->Twig->render($main_config['voucher_number'],$twig_data),
			'jumlah' => $payment['PaymentOrder']['amount'],
			'tanggal_entry' => $tanggal_entry
		);		

		//get
		$bank_akun =  $this->getAkunByBank($bankAccount,$payment['PaymentOrder']['Payment']['bank']);

		foreach( $entry_config['JurnalConfig'] as $idx=>$cfg )
		{
			if( (int)$cfg['config_type'] === 1 ){continue;}		
			if( $cfg['jurnal_type'] == 'debet' )
			{			
				$response[$idx]['debit'] = $response['jumlah'];
				$response[$idx]['kredit'] = 0;
			
				if( $bankAccount['use_bank'] === 'debet' )
				{
					$response[$idx]['coa_id'] = $bank_akun;
				}
				else
				{
					if( (int)$use_tax === 1 ){
						$response[$idx]['coa_id'] = $cfg['tax_coa'];
					}	
					else{
						$response[$idx]['coa_id'] = $cfg['coa_id'];
					}
				}			
			}
			else
			{			
				$response[$idx]['debit'] = 0;
				$response[$idx]['kredit'] = $response['jumlah'];	
				
				if( $bankAccount['use_bank'] === 'kredit' ){
					$response[$idx]['coa_id'] = $bank_akun;
				}else{
					if( (int)$use_tax === 1 )
						$response[$idx]['coa_id'] = $cfg['tax_coa'];	
					else
						$response[$idx]['coa_id'] = $cfg['coa_id'];	
				}											
			}						
					
			$response[$idx]['keterangan'] = $this->Twig->render($cfg['nama_transaksi'],$twig_data);								
			
			$response['nama_transaksi'] = $this->Twig->render($main_config['nama_transaksi'],$twig_data);
		}		

		unset($response['Payment']);
		unset($response['jumlah']);
		$this->save($response,FALSE);					
	}

	protected function getInvoiceCode($invoice,$lunas = FALSE)
	{			
		$invoice_code = explode('-',$invoice);
		$length = count($invoice_code);
				
		$day = ( strlen($invoice_code[ $length - 3 ]) < 2 ) ? '0'.$invoice_code[ $length - 3 ] : $invoice_code[ $length - 3 ];
		$tgl = $invoice_code[ $length - 2 ].' '.substr($invoice_code[$length - 1], 0,4);
		$month = substr($invoice_code[ $length - 2 ],0,3);
		
		$code = $day.'/'.strtoupper($month).'/'.substr($invoice_code[$length - 1], 2,2);
		
		if( $lunas === FALSE)
			return 'INV-DP/'.$code;
		else
			return 'INV-L/'.$code;
	}

	//buat invoice
	public function createJurnalInvoiceCreate($order,$invoice)
	{
		//pull config
		$config = ClassRegistry::init('Jconfig');
		$entry_config = $config->read(NULL,3);	
		if( count($entry_config) <= 0 ) return FALSE;
									
		$main_config = $this->getPrimaryConfig($entry_config);								
		
		$invoice['invoiceID'] = $this->getInvoiceCode($invoice['invoiceID'],TRUE);
		
	    $invoice_data = array(
		    'paymentTerm' => $invoice['paymentTerm'],
		    'jatuh_tempo' => $invoice['jatuh_tempo'],
		    'totalShipping' => $invoice['totalShipping'],
		    'InvoiceID' => $invoice['invoiceID']
		);			
		
		$twig_data = array(
			'Invoice' => $invoice_data,
			'Customer' => $order['Customer']
		);
		
		//template for entry date
		$extra_config = json_decode($main_config['extra'],TRUE);
		$tpl_entry_date = $this->Arr->Get($extra_config,'entry_date',self::ENTRY_DATE_TPL);
		if( $tpl_entry_date  === self::ENTRY_DATE_TPL ){
			$tanggal_entry =  date('Y-m-d H:i:s',time());
		}else{				
			$tanggal_entry =  $this->Twig->render($tpl_entry_date,$twig_data);
		}			
		
		$response = array(
			'voucher_number' => $this->Twig->render($main_config['voucher_number'],$twig_data),
			'jumlah' => $order['Order']['sell_price'], 
			'tanggal_entry' => $tanggal_entry
		);		
		
		$tax_config = $this->getTaxConfig($entry_config['JurnalConfig']);	
		$jml = floatval($response['jumlah']) - floatval($order['Order']['dp_customer']);
		$tmp = $this->calculateTax($jml);
		$tax_value = floatval($jml) - floatval($tmp);
		
		//with tax
		$after_tax = ( floatval($jml) + floatval($tax_value) )+ floatval($invoice['totalShipping']);	
		//no tax
		$jml = floatval($jml) + floatval($invoice['totalShipping']);		

		foreach( $entry_config['JurnalConfig'] as $idx=>$cfg )
		{
			if( (int)$cfg['config_type'] === 1 ) continue;						
			
			if( $cfg['jurnal_type'] == 'debet' )
			{
				$response[$idx]['debit'] = $after_tax;			
				if( is_array($tax_config) && $invoice['paymentTerm'] === 'transferPT')
				{
					$tax_index = $tax_config['index'];				
					if( $tax_config['config']['jurnal_type'] === 'debet' ){				
						$response[$tax_index]['debit'] = $tax_value;					
						$response[$tax_index]['kredit'] = 0;	
						$response[$idx]['debit'] = $jml;																						
					}									
										
					$cfg['coa_id'] = $cfg['tax_coa'];
					$response[$tax_index]['keterangan'] = $this->Twig->render($tax_config['config']['nama_transaksi'],$twig_data);
					$response[$tax_index]['coa_id'] = $tax_config['config']['coa_id'];										
				}
												
				$response[$idx]['kredit'] = 0;					
				$response[$idx]['keterangan'] = $this->Twig->render($cfg['nama_transaksi'],$twig_data);
				$response[$idx]['coa_id'] = $cfg['coa_id'];								
			}
			else
			{
				$response[$idx]['kredit'] = $after_tax;
				if( is_array($tax_config) && $invoice['paymentTerm'] === 'transferPT')
				{
					$tax_index = $tax_config['index'];									
					if( $tax_config['config']['jurnal_type'] === 'kredit' ){							
						$response[$tax_index]['kredit'] = $tax_value;						
						$response[$tax_index]['debit'] = 0;	
						$response[$idx]['kredit'] = $jml;										
					}
									
					$cfg['coa_id'] = $cfg['tax_coa'];	
					$response[$tax_index]['keterangan'] = $this->Twig->render($tax_config['config']['nama_transaksi'],$twig_data);
					$response[$tax_index]['coa_id'] = $tax_config['config']['coa_id'];
				}
												
				$response[$idx]['debit'] = 0;																																								
			}
			$response[$idx]['coa_id'] = $cfg['coa_id'];				
			$response[$idx]['keterangan'] = $this->Twig->render($cfg['nama_transaksi'],$twig_data);								
			$response['nama_transaksi'] = $this->Twig->render($main_config['nama_transaksi'],$twig_data);
		}		

		unset($response['jumlah']);
		$this->save($response,FALSE);			
	}

	//wait payment
	// fix it!!!!!!~!!@!!Q
	public function createJurnalTerimaDP($data,$use_tax,$customer)
	{
		//pull config
		$config = ClassRegistry::init('Jconfig');
		$entry_config = $config->read(NULL,5);
		$bankAccount = json_decode($entry_config['Jconfig']['extra'],TRUE);
		
		if( count($entry_config) <= 0 ) return false;
		
		$main_config = $this->getPrimaryConfig($entry_config);
		$tanggal_entry = date('Y-m-d H:i:s',time());
		
		$Invoice = ClassRegistry::init('Invoice');
		$Invoice->unbindAll();
		$result_invoice = $Invoice->find('all',array(
			'conditions' => array(
				'Invoice.order_id' => $data['PaymentOrder']['order_id']
			)
		));
			
		$invoice = NULL;
		foreach( $result_invoice as $inv )
		{
			if( strtoupper(substr($inv['Invoice']['path'],0,1)) !== 'L' ){
				$invoice = $inv['Invoice'];
				break;
			}
		}
		
		$invoice_code = 'NULL';
		if( $invoice )
		{
			$invoice_code = $this->getInvoiceCode($invoice['path']);
		}
		else
		{
			//kasus jika invoice Lunas tidak ditemukan
			$invoice_code = 'NULL';
		}
		unset($invoice);
		
		//fetch transactionID from payments table
		$Payment = ClassRegistry::init('Payment');
		$payment = $Payment->read(NULL,$data['PaymentOrder']['payment_id']);

		$response = array(
			'jumlah' => $data['PaymentOrder']['amount'],
			'Customer' => $customer,
			'Payment' => array('trans_code' => $payment['Payment']['trans_code'])
		);		
		
		$twig_data = array('Payment' => $response['Payment'],'Customer' => $response['Customer'],'InvoiceID' => $invoice_code);	
				
		//template for entry date
		$extra_config = json_decode($main_config['extra'],TRUE);
		$tpl_entry_date = $this->Arr->Get($bankAccount,'entry_date',self::ENTRY_DATE_TPL);
		if( $tpl_entry_date  === self::ENTRY_DATE_TPL ){
			$tanggal_entry =  date('Y-m-d H:i:s',time());
		}else{				
			$tanggal_entry =  $this->Twig->render($tpl_entry_date,$twig_data);
		}			
		
		$response['voucher_number'] = $this->Twig->render($main_config['voucher_number'],$twig_data);
		$response['tanggal_entry'] = $tanggal_entry;
		$tax_config = $this->getTaxConfig($entry_config['JurnalConfig']);
			
		//get 
		$bank_akun =  $this->getAkunByBank($bankAccount,$payment['Payment']['bank']);

		foreach( $entry_config['JurnalConfig'] as $idx=>$cfg )
		{
			if( (int)$cfg['config_type'] === 1 ) continue;
			
			if( $cfg['jurnal_type'] == 'debet' )
			{
				$response[$idx]['debit'] = $response['jumlah'];
											
				if( $bankAccount['use_bank'] == 'debet' ){
					$cfg['coa_id'] = $bank_akun;
				}elseif( (int)$use_tax === 1 ){
					$cfg['coa_id'] = $cfg['tax_coa'];
				}
				$response[$idx]['coa_id'] = $cfg['coa_id'];														
												
				$response[$idx]['kredit'] = 0;				
			}
			else
			{			
				$response[$idx]['kredit'] = $response['jumlah'];
														
				if( $bankAccount['use_bank'] == 'kredit' ){
					$cfg['coa_id'] = $bank_akun;
				}
				elseif( (int)$use_tax === 1 ){
					$cfg['coa_id'] = $cfg['tax_coa'];	
				}				
				
				$response[$idx]['coa_id'] = $cfg['coa_id'];							
								
				$response[$idx]['debit'] = 0;								
			}						
									
			$response[$idx]['keterangan'] = $this->Twig->render($cfg['nama_transaksi'],$twig_data);											
			$response['nama_transaksi'] = $this->Twig->render($main_config['nama_transaksi'],$twig_data);
		}		
		
		unset($response['jumlah']);
		unset($response['Customer']);
		unset($response['Payment']);
		$this->save($response,FALSE);					
	}

	//ceck order and invoice terima DP
	public function createJurnalCheckOrder($data,$use_tax)
	{		
		//pull config
		$config = ClassRegistry::init('Jconfig');
		$entry_config = $config->read(NULL,4);
		if( count($entry_config) <= 0 ) return false; //return if no config found
		
		$main_config = $this->getPrimaryConfig($entry_config);
		
		$response = array(
			'jumlah' => $data['customPrice'],
			'Invoice' => array( 'InvoiceID' => $this->getInvoiceCode($data['path']) ),
			'Customer' => $data['Customer'],
		);		
		$twig_data = array('Invoice' => $response['Invoice'],'Customer' => $response['Customer']);

		//template for entry date
		$extra_config = json_decode($main_config['extra'],TRUE);
		$tpl_entry_date = $this->Arr->Get($main_config,'entry_date',self::ENTRY_DATE_TPL);
		if( $tpl_entry_date  === self::ENTRY_DATE_TPL ){
			$tanggal_entry =  date('Y-m-d H:i:s',time());
		}else{				
			$tanggal_entry =  $this->Twig->render($tpl_entry_date,$twig_data);
		}		

		$response['tanggal_entry'] = $tanggal_entry;
		$response['voucher_number'] = $this->Twig->render($main_config['voucher_number'],$twig_data);
		
		$tax_config = $this->getTaxConfig($entry_config['JurnalConfig']);

		foreach( $entry_config['JurnalConfig'] as $idx=>$cfg )
		{
			if( (int)$cfg['config_type'] !== 0 ) continue;
			
			if( $cfg['jurnal_type'] == 'debet' )
			{			
				if( is_array($tax_config) && (int)$use_tax === 1 )
				{
					$tax_index = $tax_config['index'];
					$jml = $response['jumlah'];	
					$jml = $this->calculateTax($jml);			
					$tax_value = floatval($response['jumlah']) - floatval($jml);	
					
					if( $tax_config['config']['jurnal_type'] === 'debet' ){					
						$response[$tax_index]['debit'] = $tax_value;						
						$response[$tax_index]['kredit'] = 0;
						$response[$idx]['debit'] = $jml;						
					}else{
						$response[$tax_index]['kredit'] = $tax_value;						
						$response[$tax_index]['debit'] = 0;
						$response[$idx]['debit'] = $response['jumlah'];												
					}
					
					$cfg['coa_id'] = $cfg['tax_coa'];
					$response[$tax_index]['keterangan'] = $this->Twig->render($tax_config['config']['nama_transaksi'],$twig_data);
					$response[$tax_index]['coa_id'] = $tax_config['config']['coa_id'];
				}else{ $response[$idx]['debit'] = $response['jumlah']; }
												
				$response[$idx]['kredit'] = 0;
			}
			else
			{
				if( is_array($tax_config) && (int)$use_tax === 1 )
				{
					$tax_index = $tax_config['index'];
					$jml = $response['jumlah'];	
					$jml = $this->calculateTax($jml);			
					$tax_value = floatval($response['jumlah']) - floatval($jml);	
					
					if( $tax_config['config']['jurnal_type'] === 'kredit' ){					
						$response[$tax_index]['kredit'] = $tax_value;						
						$response[$tax_index][''] = 0;
						$response[$idx]['kredit'] = $jml;
					}else{
						$response[$tax_index]['debit'] = $tax_value;						
						$response[$tax_index]['kredit'] = 0;								
						$response[$idx]['kredit'] = $response['jumlah'];																
					}
					
					$cfg['coa_id'] = $cfg['tax_coa'];
					$response[$tax_index]['keterangan'] = $this->Twig->render($tax_config['config']['nama_transaksi'],$twig_data);
					$response[$tax_index]['coa_id'] = $tax_config['config']['coa_id'];
				}else{ $response[$idx]['kredit'] = $response['jumlah']; }
												
				$response[$idx]['debit'] = 0;									
			}
			$response[$idx]['coa_id'] = $cfg['coa_id'];				
			$response[$idx]['keterangan'] = $this->Twig->render($cfg['nama_transaksi'],$twig_data);								
			
			$response['nama_transaksi'] = $this->Twig->render($main_config['nama_transaksi'],$twig_data);
		}		
		
		unset($response['jumlah']);
		unset($response['Customer']);
		unset($response['Invoice']);
		
		$this->save($response,FALSE);		
	}
	
	protected function getTaxConfig($sources)
	{		
		$result = NULL;
		foreach( $sources as $idx=>$src ){
			if( (int)$src['config_type'] === 1 && (int)$src['coa_id'] > 0 ){
				$result = array('config' => $src,'index' => $idx);
				break;
			}
		}
		
		return $result;
	}
}