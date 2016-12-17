<?php
App::uses('SchoolTeacher', 'Model');

/**
 * SchoolTeacher Test Case
 *
 */
class SchoolTeacherTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.school_teacher',
		'app.school_class',
		'app.school_student',
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
		$this->SchoolTeacher = ClassRegistry::init('SchoolTeacher');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SchoolTeacher);

		parent::tearDown();
	}

}
