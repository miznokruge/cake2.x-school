<?php
/* Message Test cases generated on: 2014-12-31 19:12:04 : 1420049524*/
App::uses('Message', 'Model');

/**
 * Message Test Case
 *
 */
class MessageTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.message', 'app.user', 'app.group', 'app.note', 'app.order', 'app.customer', 'app.city', 'app.state', 'app.groups_state', 'app.customer_state', 'app.supplier_state', 'app.delivery_state', 'app.suggest_order', 'app.buy', 'app.supplier', 'app.salesman', 'app.shipping', 'app.shipper', 'app.payment', 'app.payment_order', 'app.po', 'app.outpayment', 'app.invoice', 'app.purchase', 'app.ticket', 'app.ticket_type', 'app.ticket_state', 'app.ticket_note', 'app.survey_answer', 'app.survey', 'app.payment_giro', 'app.orders_supplier', 'app.quote', 'app.quote_state', 'app.quote_items', 'app.quote_imgs', 'app.quote_note', 'app.sendto');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Message = ClassRegistry::init('Message');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Message);

		parent::tearDown();
	}

}
