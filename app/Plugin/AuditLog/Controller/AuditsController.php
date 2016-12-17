<?php

App::uses('AuditAppController', 'AuditLog.Controller');

class AuditsController extends AuditLogAppController {

	public $uses = ['AuditLog.Audit'];

	public $helpers = ['AuditLog.AuditLog'];

	public $presetVars = true;

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Audit->setupSearchPlugin();

		$this->Crud->on('beforeLookup', function($event) {
			$this->Paginator->settings['group'] = $this->request->query('id_field');
		});
	}

	public function admin_index() {
		$this->Crud->on('beforePaginate', function($event) {
			if ($model = $this->request->query('model')) {
				$Instance = ClassRegistry::init($model);

				$displayField = $Instance->displayField;

				$this->Paginator->settings['fields'] = [
					'Audit.id',
					'Audit.event',
					'Audit.model',
					'Audit.entity_id',
					'Audit.description',
					'Audit.source_id',
					'Audit.created',
					'Audit.delta_count',
					$model . '.' . $displayField
				];

				$this->Paginator->settings['joins'][] = [
					'alias' => $model,
					'table' => $Instance->useTable,
					'conditions' => [
						$Instance->alias . '.id = Audit.entity_id'
					],
					'type' => 'INNER'
				];

				$this->set(compact('model', 'displayField'));
			}
		});

		return $this->Crud->execute();
	}

	public function admin_view($id) {
		$this->Crud->on('beforeFind', function($event) {
			$event->subject->query['contain'][] = 'AuditDelta';
		});

		return $this->Crud->execute();
	}

}
