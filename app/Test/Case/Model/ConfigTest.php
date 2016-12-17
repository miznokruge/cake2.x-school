<?php
/* Config Test cases generated on: 2014-12-02 17:12:12 : 1417536732*/
App::uses('Config', 'Model');

/**
 * Config Test Case
 *
 */
class ConfigTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.config');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Config = ClassRegistry::init('Config');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Config);

		parent::tearDown();
	}

}
