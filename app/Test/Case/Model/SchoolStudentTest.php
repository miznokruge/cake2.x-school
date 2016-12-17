<?php
App::uses('SchoolStudent', 'Model');

/**
 * SchoolStudent Test Case
 *
 */
class SchoolStudentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.school_student',
		'app.school_class',
		'app.school_teacher',
		'app.school_exam',
		'app.school_subject'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SchoolStudent = ClassRegistry::init('SchoolStudent');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SchoolStudent);

		parent::tearDown();
	}

}
