<?php
/**
 * Sugggested Edit Order by accountant specific Component
 */
class SuggestComponent extends Component
{
    public $components = array(
        'Arr','Util'
    );	

	protected $_excluded_key = array('OrderSupplier','suggest_id','Keterangan','Supplier','Buy','Shipping','Customer');
	protected $_changed = array();
	
	/**
	* @param array $suggest_order
	*/
	public function compare($current_order,$suggest_order)
	{				
		if( empty($current_order) || empty($suggest_order) ){
			throw new InternalErrorException('not supplier current_order or suggest_order');
		}

		//extract order supplier from current_order
		$order_suppliers = array();
		foreach( $current_order['Supplier'] as $key=>$osup )
			$order_suppliers[$key] = $osup[ 'OrdersSupplier' ];

		$Supplier = ClassRegistry::init('Supplier');
		$suggest_order['OrderSupplier'] = $this->Util->toSaveableArray($suggest_order['OrderSupplier']);

		foreach( $order_suppliers as $idx=>$os )
		{								
			$sug = $this->Arr->Get($suggest_order['OrderSupplier'],$idx);
			
			if( is_array($sug) && is_array($current_order['Supplier'][$idx]['OrdersSupplier']) )
			{
				foreach( $sug as $key=>$val )
				{
					$_val = $this->Arr->Get($current_order['Supplier'][ $idx ]['OrdersSupplier'],$key);
					if( $key === 'latest_delivery_date' )
					{					
						$_val = date('Y-m-d',strtotime($_val));
						$val = date('Y-m-d',strtotime($val));																	
					}
					elseif( $key == 'dp' )
					{
						$_val = $this->Util->filterPrice($_val);
						$val = $this->Util->filterPrice($val);	
					}

					if( $val != $_val )
					{				
						if( $key != 'supplier_id' )
						{						
							$this->_changed['cols']['OrdersSupplier'][$idx][$key] = $_val;	
						}
						else
						{ 								
							$supplier = $Supplier->find('first',array( 'conditions' => array('Supplier.id' => $_val) ));						
							$this->_changed['cols']['OrdersSupplier'][$idx][$key] = $supplier['Supplier']['name'];
						}	

						$current_order['Supplier'][$idx]['OrdersSupplier'][$key] = $val;
					}
				}
			}	
			else
			{				
				$this->_changed['cols']['OrdersSupplier'][$idx] = '*';
				$current_order['Supplier'][ $idx]['OrdersSupplier'][] = $sug;
			}
		}
		
		$Supplier->unbindAll();
		foreach( $suggest_order['Buy'] as $idx=>$buy )
		{		
			if( is_array($this->Arr->Get($current_order['Buy'],$idx)) )
			{	
				foreach( $buy as $key=>$b )
				{
					$_val = trim($current_order['Buy'][$idx][$key]);
					if( in_array($key, array('list_price','sell_price')) )
					{																	
						$b =  $this->Util->filterPrice( number_format($b) );
						$_val = $this->Util->filterPrice( number_format($_val) );														
					}			

					if( trim($b) != $_val )
					{						
						if( $key != 'supplier_id' )
						{						
							$this->_changed['cols']['Buy'][$idx][$key] = $_val;								
						}else{ 	
							$supplier = $Supplier->find('first',array( 'conditions' => array('Supplier.id' => $_val) ));						
							$this->_changed['cols']['Buy'][$idx][$key] = $supplier['Supplier']['name'];
						}		
						
						$current_order['Buy'][$idx][$key] = $b;				
					}													
				}
			}
			else
			{				
				$this->_changed['cols']['Buy'][] = '*';				
				$current_order['Buy'][] = $buy;
			}
		}	
		//die(debug( $this->_changed['cols'] ));
		unset($Supplier);
		
		foreach( $suggest_order['Customer'] as $idx=>$cust )
		{
			if( trim($cust) != trim($current_order['Customer'][$idx]) ){					
				$this->_changed['cols']['Customer'][$idx] = $current_order['Customer'][$idx];
				$current_order['Customer'][$idx] = $cust;						
			}
		}		

		//Shipping
		$shipping = $this->Arr->Get($suggest_order,'Shipping',array());
		foreach( $shipping as $key=>$ship )
		{			
			$sp = $this->Arr->Get($current_order['Shipping'],$key);			
			if( is_array($sp) )
			{
				foreach( $ship as $idx=>$val )
				{
					$_val =  $this->Arr->Get($current_order['Shipping'][$key],$idx);					
					if( in_array($idx, array('sell_price','buy_price') ) ){												
						$_val = $this->Util->filterPrice( number_format($_val) );
						$val = $this->Util->filterPrice( number_format($val) );										
					}

					if( trim($val) != $_val )
					{
						$current_order['Shipping'][$key][$idx] = $val;
						$this->_changed['cols']['Shipping'][$key][$idx] = $_val;	
						print_r( $this->_changed['cols']['Shipping'][$key][$idx] );
					}	
				}
			}
			else
			{
				$this->_changed['cols']['Shipping'][$key] = '*';	
				$current_order['Shipping'][$key] = $ship;	
			}	
		} 		

		/** 
		* Order
		*/
		foreach( $suggest_order['Order'] as $_key=>$ord )
		{
			$_val =  $this->Arr->Get($current_order['Order'],$_key);	
			if( in_array($_key, array('sell_price','buy_price','dp_customer') ) ){
				$_val = $this->Util->filterPrice( number_format($_val) );
				$ord = $this->Util->filterPrice($ord);						
			}

			if( $ord !== $_val )
			{
				$current_order['Order'][$_key] = $ord;
				$this->_changed['cols']['Order'][$_key] = $_val;
			}
		}

		$this->_changed['orders'] = $current_order;
		
		return $this->_changed;
	}

	/**
	* internal method
	* @return boolean
	*/
	protected function _compare( $_key ,array &$order,array $suggest)
	{		
		foreach( $suggest[$_key] as $idx=>$sug )
		{		
			/* do recursive */
			if( is_array( $sug ) && is_array($this->Arr->Get($order[$_key],$idx) ) ){
				$this->_compare( $idx,$sug,$this->Arr->Get($order[$_key],$idx) );
			}	

			if( is_array( $sug ) && !is_array($this->Arr->Get($order[$_key],$idx) ) ){
				$this->_changed['cols'][ $_key ][$idx] = '*';
				$order[$_key][$idx] = $sug;
			}		

			if( $this->Arr->Get($suggest[$_key],$idx) !== $this->Arr->Get($order[$_key],$idx) ){
				$this->_changed['cols'][ $_key ][$idx ] = $this->Arr->Get($order[$_key],$idx);
				$order[$_key][ $idx ] = $this->Arr->Get($suggest[$_key],$idx);
			}
		}
	}
}