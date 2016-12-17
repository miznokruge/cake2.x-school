<?php
App::uses('UtilComponent', 'Controller/Component');
App::uses('AppController', 'Controller');

class UtilTest extends CakeTestCase
{
	protected $Util;

    public function setUp() 
    {
    	parent::setup();
    	$this->Util = new UtilComponent(new ComponentCollection());
    }

    public function testToSaveableArray()
    {
    	$requestData = array(
	    		'qty' => array(2,3),
	    		'sell_price' => array(50,70),
	    		'price_list' => array(40,50)
    	);

    	$expected = array(  		
			array(
				'qty' => 2,
				'sell_price' => 50,
				'price_list' => 40
			),
 			array(
 				'qty' => 3,
				'sell_price' => 70,
				'price_list' => 50
			),   			
    	);

    	$this->assertEquals( $expected , $this->Util->toSaveableArray($requestData) );

    	//test with wrong param
     	$requestData = array(
	    		'qty' => array(2),
	    		'sell_price' => array(50,70),
	    		'price_list' => array(40,50)
    	);   	

    	$expected = array(  		
			array(
				'qty' => 2,
				'sell_price' => 50,
				'price_list' => 40
			),
 			array(
 				'qty' => NULL,
				'sell_price' => 70,
				'price_list' => 50
			) 			
    	);

     	$result = $this->Util->toSaveableArray($requestData);
    }

    public function testFilterPrice()
    {
    	//transform 'Rp 20,500.00' => 20500.00
    	$this->assertEquals('20500.00',$this->Util->filterPrice('20,500.00'));
    }
}