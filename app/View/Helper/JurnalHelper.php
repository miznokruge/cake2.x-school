<?php
App::uses('AppHelper', 'View/Helper');

class JurnalHelper extends AppHelper {

	//jurnal getTax Config
	//@tipe = kredit/debet
	public function getTaxConfig(array $sources,$tipe)
	{
		$result = NULL;
		foreach( $sources as $src )
		{
			if( (int)$src['config_type'] === 1 && $src['jurnal_type'] == $tipe ){
				$result = $src;
				break;
			}
		}
		
		return $result;
	}
	
	//@tipe = kredit/debet
	public function getConfig(array $sources,$tipe)
	{
		$result = NULL;
		foreach( $sources as $src )
		{
			if( (int)$src['config_type'] === 0 && $src['jurnal_type'] == $tipe ){
				$result = $src;
				break;
			}
		}
		
		return $result;		
	}
	
	/*public function getPrimaryConfig($source)
	{
		$result = NULL;
		foreach( $source as $src )
		{
			if( (int)$src['JurnalConfig']['is_tax'] === 2 ){
				$result = $src;
				break;
			}
		}
		
		return $result;
	}*/
}