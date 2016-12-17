<?php
/* JurnalTemplateDetails Test cases generated on: 2015-01-01 06:27:15 : 1420090035*/
App::uses('JurnalTemplateDetailsController', 'Controller');

/**
 * TestJurnalTemplateDetailsController *
 */
class TestJurnalTemplateDetailsController extends JurnalTemplateDetailsController {
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
 * JurnalTemplateDetailsController Test Case
 *
 */
class JurnalTemplateDetailsControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.jurnal_template_detail', 'app.coa', 'app.jurnal_template');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->JurnalTemplateDetails = new TestJurnalTemplateDetailsController();
		$this->JurnalTemplateDetails->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->JurnalTemplateDetails);

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
