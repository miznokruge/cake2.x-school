<?php
App::uses('SchoolExam', 'Model');

/**
 * SchoolExam Test Case
 *
 */
class SchoolExamTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.school_exam',
		'app.school_student',
		'app.school_subject'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SchoolExam = ClassRegistry::init('SchoolExam');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SchoolExam);

		parent::tearDown();
	}

}
