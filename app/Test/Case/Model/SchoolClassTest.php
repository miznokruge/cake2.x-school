<?php
App::uses('SchoolClass', 'Model');

/**
 * SchoolClass Test Case
 *
 */
class SchoolClassTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.school_class',
		'app.school_teacher',
		'app.school_student'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SchoolClass = ClassRegistry::init('SchoolClass');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SchoolClass);

		parent::tearDown();
	}

}
