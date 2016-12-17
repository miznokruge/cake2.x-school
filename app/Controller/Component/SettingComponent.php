<?php
/**
 *
 *	Store system config on database
 *
 *	@author Mizno Kruge
 */
App::Import('ConnectionManager');

class SettingComponent extends Component {

	protected $db;

	public function __construct(ComponentCollection $collection, $settings = array()) 
	{
		parent::__construct($collection,$settings);
		$this->db = ConnectionManager::getDataSource('default');
	}	

	public function get($key,$default = null)
	{
		$row = $this->db->query('SELECT * FROM `settings` WHERE `key` = "'.$key.'"');
		if( count($row) > 0 )
			return $row[0]['settings']['value'];
		else
			return $default;
	}

	public function set($key,$value)
	{
		$row = $this->get($key);
		if( !is_numeric($value) ){
			$value = '"'.$value.'"';
		}		

		$key = '"'.$key.'"';

		if( $row === NULL )
		{
			$this->db->query('INSERT `settings`(`key`,`value`) VALUES('.$key.','.$value.')');
		}
		else
		{
			$this->db->query('UPDATE `settings` SET `value` = '.$value.' WHERE `key` = '.$key);	
		}		
	}

	public function all()
	{
		return $this->db->query('SELECT * FROM `settings` as `Setting`');
	}
}