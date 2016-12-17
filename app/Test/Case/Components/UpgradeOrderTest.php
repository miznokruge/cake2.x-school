<?php
App::uses('UpgradeOrderComponent', 'Controller/Component');
App::uses('AppController', 'Controller');

class UpgradeOrderTest extends CakeTestCase
{
	protected $upgradeOrder;

    public function setUp() 
    {
    	parent::setup();
    	$this->upgradeOrder = new UpgradeOrderComponent(new ComponentCollection());
    }

    public function testSumSellPrice()
    {
    	$shippings = array(
    		array(
	    		'sell_price' => 15,
	    		'buy_price' => 5,
	    		'supplier_id' => 0.0,
	    		'shipper_id' => 1,
	    		'order_id' => 128
    		)
    	);

    	//tanpa pajak
    	$this->assertEquals( 115.0, $this->upgradeOrder->sumSellPrice($this->defaultItems(),$shippings) );

        //dengan pajak
        $this->assertEquals(125.0,$this->upgradeOrder->sumSellPrice($this->defaultItems(),$shippings,TRUE) );   	
    }

    public function testSumItemsSellPrice()
    {
        $_items = array(
                'qty' => 3,
                'supplier_id' => 1,
                'name' => 'R-gjghkghk',
                'bahan' => 'Hijau',
                'sell_price' => 30,
                'list_price' => 20,
                'order_id' => 128,
                'user_id' => 22
            );        

        //qty * sell_price
        $items = $this->defaultItems();
        $items[] = $_items;
        $this->assertEquals(190.0,$this->upgradeOrder->sumItemsSellPrice($items));        
    }
    
    //------------------------ wrapper of fixture data -------------------//
    protected function defaultItems()
    {
        return array(
            array(
                'qty' => 2,
                'supplier_id' => 1,
                'name' => 'R-gjghkghk',
                'bahan' => 'Hijau',
                'sell_price' => 50,
                'list_price' => 40,
                'order_id' => 128,
                'user_id' => 22
            )
        );
    }
}