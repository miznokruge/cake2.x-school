<?php
/* JurnalTemplate Fixture generated on: 2015-01-01 06:23:02 : 1420089782 */

/**
 * JurnalTemplateFixture
 *
 */
class JurnalTemplateFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'name' => array('type' => 'string', 'null' => false, 'length' => 200, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1'),
		'created_by' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1'),
		'created_date' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'last_update_by' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1'),
		'last_update_date' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'isdelete' => array('type' => 'string', 'null' => false, 'default' => 'N', 'length' => 1, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1'),
		'deleteby' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1'),
		'deletedate' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'createdby' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1'),
		'createddate' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'updatedby' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1'),
		'updateddate' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
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
			'name' => 'Lorem ipsum dolor sit amet',
			'created_by' => 'Lorem ipsum dolor sit amet',
			'created_date' => '2015-01-01 06:23:02',
			'last_update_by' => 'Lorem ipsum dolor sit amet',
			'last_update_date' => '2015-01-01 06:23:02',
			'isdelete' => 'Lorem ipsum dolor sit ame',
			'deleteby' => 'Lorem ipsum dolor sit amet',
			'deletedate' => '2015-01-01 06:23:02',
			'createdby' => 'Lorem ipsum dolor sit amet',
			'createddate' => '2015-01-01 06:23:02',
			'updatedby' => 'Lorem ipsum dolor sit amet',
			'updateddate' => '2015-01-01 06:23:02'
		),
	);
}
