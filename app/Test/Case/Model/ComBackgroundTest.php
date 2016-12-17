<?php
/* ComBackground Test cases generated on: 2014-12-14 00:56:29 : 1418514989*/
App::uses('ComBackground', 'Model');

/**
 * ComBackground Test Case
 *
 */
class ComBackgroundTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.com_background');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->ComBackground = ClassRegistry::init('ComBackground');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ComBackground);

		parent::tearDown();
	}

}
