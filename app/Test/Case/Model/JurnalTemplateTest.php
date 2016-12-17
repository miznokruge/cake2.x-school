<?php
/* JurnalTemplate Test cases generated on: 2015-01-01 06:23:02 : 1420089782*/
App::uses('JurnalTemplate', 'Model');

/**
 * JurnalTemplate Test Case
 *
 */
class JurnalTemplateTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.jurnal_template', 'app.jurnal_template_detail');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->JurnalTemplate = ClassRegistry::init('JurnalTemplate');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->JurnalTemplate);

		parent::tearDown();
	}

}
