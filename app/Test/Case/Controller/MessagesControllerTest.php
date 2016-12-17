<?php
/* Messages Test cases generated on: 2014-12-31 19:13:07 : 1420049587*/
App::uses('MessagesController', 'Controller');

/**
 * TestMessagesController *
 */
class TestMessagesController extends MessagesController {
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

/**
 * MessagesController Test Case
 *
 */
class MessagesControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.message', 'app.user', 'app.group', 'app.note', 'app.order', 'app.customer', 'app.city', 'app.state', 'app.groups_state', 'app.customer_state', 'app.supplier_state', 'app.delivery_state', 'app.suggest_order', 'app.buy', 'app.supplier', 'app.salesman', 'app.shipping', 'app.shipper', 'app.payment', 'app.payment_order', 'app.po', 'app.outpayment', 'app.invoice', 'app.purchase', 'app.ticket', 'app.ticket_type', 'app.ticket_state', 'app.ticket_note', 'app.survey_answer', 'app.survey', 'app.payment_giro', 'app.orders_supplier', 'app.quote', 'app.quote_state', 'app.quote_items', 'app.quote_imgs', 'app.quote_note');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Messages = new TestMessagesController();
		$this->Messages->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Messages);

		parent::tearDown();
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {

	}

/**
 * testView method
 *
 * @return void
 */
	public function testView() {

	}

/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {

	}

/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {

	}

/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {

	}

}
