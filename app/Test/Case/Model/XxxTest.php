<?php
App::uses('Xxx', 'Model');

/**
 * Xxx Test Case
 *
 */
class XxxTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.xxx'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Xxx = ClassRegistry::init('Xxx');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Xxx);

		parent::tearDown();
	}

}
