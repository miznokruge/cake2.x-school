<?php
/* JurnalTemplates Test cases generated on: 2015-01-01 06:27:56 : 1420090076*/
App::uses('JurnalTemplatesController', 'Controller');

/**
 * TestJurnalTemplatesController *
 */
class TestJurnalTemplatesController extends JurnalTemplatesController {
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
 * JurnalTemplatesController Test Case
 *
 */
class JurnalTemplatesControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.jurnal_template', 'app.jurnal_template_detail', 'app.coa');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->JurnalTemplates = new TestJurnalTemplatesController();
		$this->JurnalTemplates->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->JurnalTemplates);

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
