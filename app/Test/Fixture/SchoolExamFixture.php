<?php
/**
 * SchoolExamFixture
 *
 */
class SchoolExamFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'school_student_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'school_subject_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'score' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '5,2', 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'school_student_id' => 1,
			'school_subject_id' => 1,
			'created' => '2016-12-17 08:23:17',
			'score' => 1
		),
	);

}
