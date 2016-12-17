<?php
App::uses('SchoolSubject', 'Model');

/**
 * SchoolSubject Test Case
 *
 */
class SchoolSubjectTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.school_subject',
		'app.school_exam',
		'app.school_student',
		'app.school_class',
		'app.school_teacher'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SchoolSubject = ClassRegistry::init('SchoolSubject');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SchoolSubject);

		parent::tearDown();
	}

}
