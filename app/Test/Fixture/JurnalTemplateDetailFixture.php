<?php
/* JurnalTemplateDetail Fixture generated on: 2015-01-01 06:27:15 : 1420090035 */

/**
 * JurnalTemplateDetailFixture
 *
 */
class JurnalTemplateDetailFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'coa_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'jurnal_template_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'collate' => NULL, 'comment' => ''),
		'type' => array('type' => 'string', 'null' => false, 'default' => 'D', 'length' => 2, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1'),
		'keterangan' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1'),
		'isdelete' => array('type' => 'string', 'null' => false, 'default' => 'N', 'length' => 2, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1'),
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
			'coa_id' => 1,
			'jurnal_template_id' => 1,
			'type' => '',
			'keterangan' => 'Lorem ipsum dolor sit amet',
			'isdelete' => '',
			'deleteby' => 'Lorem ipsum dolor sit amet',
			'deletedate' => '2015-01-01 06:27:15',
			'createdby' => 'Lorem ipsum dolor sit amet',
			'createddate' => '2015-01-01 06:27:15',
			'updatedby' => 'Lorem ipsum dolor sit amet',
			'updateddate' => '2015-01-01 06:27:15'
		),
	);
}
