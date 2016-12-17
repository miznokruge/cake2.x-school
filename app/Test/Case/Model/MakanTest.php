<?php
App::uses('Makan', 'Model');

/**
 * Makan Test Case
 *
 */
class MakanTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.makan',
		'app.order',
		'app.user',
		'app.group',
		'app.note',
		'app.quote',
		'app.customer',
		'app.city',
		'app.quote_state',
		'app.quote_items',
		'app.quote_imgs',
		'app.quote_note',
		'app.supplier',
		'app.buy',
		'app.salesman',
		'app.orders_supplier',
		'app.notification',
		'app.state',
		'app.groups_state',
		'app.customer_state',
		'app.supplier_state',
		'app.delivery_state',
		'app.suggest_order',
		'app.shipping',
		'app.shipper',
		'app.payment',
		'app.payment_order',
		'app.po',
		'app.outpayment',
		'app.invoice',
		'app.purchase',
		'app.ticket',
		'app.ticket_type',
		'app.ticket_state',
		'app.ticket_note',
		'app.survey_answer',
		'app.survey',
		'app.payment_giro'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Makan = ClassRegistry::init('Makan');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Makan);

		parent::tearDown();
	}

}
