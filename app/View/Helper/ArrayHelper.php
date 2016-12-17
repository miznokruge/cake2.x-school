<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ArrayHelper
 *
 * @author user
 */
class ArrayHelper extends AppHelper {

	protected $_Array;

    public function __construct(View $view, $settings = array()) {
        parent::__construct($view, $settings);
        // Do other initialization here
        App::import('Component', 'Arr');
        $this->_Array = new ArrComponent(new ComponentCollection());	
	} 

	public function path($array, $path, $default = NULL, $delimiter = '.')
	{
		return $this->_Array->path($array,$path,$default,$delimiter);
	}

    public function get($array, $key, $default = NULL)
    {
        return isset($array[$key]) ? $array[$key] : $default;
    }

}

?>
