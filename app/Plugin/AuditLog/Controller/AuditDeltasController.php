<?php

App::uses('AuditAppController', 'AuditLog.Controller');

class AuditDeltasController extends AuditLogAppController {

	public $uses = ['AuditLog.AuditDelta'];

	public $helpers = ['AuditLog.AuditLog'];

	public $presetVars = true;

	public function beforeFilter() {
		parent::beforeFilter();

		$this->AuditDelta->setupSearchPlugin();

		$this->Crud->on('beforeLookup', function($event) {
			if ($this->request->query('id_field') === 'property_name') {
				$this->Paginator->settings['group'] = 'property_name';
			}
		});

		$this->Paginator->settings['order'] = [
			'Audit.created' => 'asc'
		];

		$this->Paginator->settings['contain'] = [
			'Audit' => [
				'fields' => [
					'Audit.id',
					'Audit.event',
					'Audit.model',
					'Audit.entity_id',
					'Audit.description',
					'Audit.source_id',
					'Audit.created',
					'Audit.delta_count'
				]
			]
		];

	}

}
