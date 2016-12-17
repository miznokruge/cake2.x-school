<?php
/* JurnalTemplateDetail Test cases generated on: 2015-01-01 06:27:15 : 1420090035*/
App::uses('JurnalTemplateDetail', 'Model');

/**
 * JurnalTemplateDetail Test Case
 *
 */
class JurnalTemplateDetailTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.jurnal_template_detail', 'app.coa', 'app.jurnal_template');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->JurnalTemplateDetail = ClassRegistry::init('JurnalTemplateDetail');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->JurnalTemplateDetail);

		parent::tearDown();
	}

}
