<?php
App::uses('File', 'Utility');
class AppTestCase extends CakeTestCase
{
	protected static function _serialize($filename,$data)
 	{
 		$filename = ROOT.DS.APP_DIR.DS.'Test/Fixtures'.DS.$filename;
		$ext = '.php';
		return file_put_contents($filename.$ext, '<?php return '.var_export($data,TRUE).';',LOCK_EX);		
 	}

	protected static function _unserialize($filename)
	{
		$filename = ROOT.DS.APP_DIR.DS.'Test/Fixtures'.DS.$filename;
		$ext = '.php';
		$result = include $filename.$ext;		
	}

	public static function Fixtures($fixtureName,$data = NULL)
	{
		if( $data === NULL )
		{
			return self::_unserialize($fixtureName);
		}
		else
		{
			return self::_serialize($fixtureName,$data);
		}
	}
}