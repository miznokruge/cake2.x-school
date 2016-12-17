<?php

App::uses('Model', 'Model');

class AuditDelta extends Model {

	public $belongsTo = [
		'Audit' => [
			'className' => 'AuditLog.Audit',
			'counterCache' => 'delta_count'
		]
	];

	public $actsAs = ['Containable'];

	public $recursive = -1;

	public function setupSearchPlugin() {
		$this->order = 'AuditDelta.property_name';

		$this->filterArgs = [
			'source_id' => [
				'type' 	=> 'value',
				'field' => 'Audit.source_id',
				'model' => 'Audit',
				'fields' => [
					'id' => 'source_id',
					'label' => 'source_id',
					'value' => 'source_id'
				]
			],
			'model' => [
				'type' 	=> 'value',
				'field' => 'Audit.model',
				'model' => 'Audit',
				'fields' => [
					'id' => 'model',
					'label' => 'model',
					'value' => 'model'
				]
			],
			'entity_id' => [
				'type' 	=> 'value',
				'field' => 'Audit.entity_id',
				'model' => 'Audit',
				'fields' => [
					'id' => 'entity_id',
					'label' => 'entity_id',
					'value' => 'entity_id'
				]
			],
			'property_name' => ['type' => 'value'],
			'old_value' 		=> ['type' => 'value'],
			'new_value' 		=> ['type' => 'value'],
		];

		$this->Behaviors->load('Search.Searchable');
	}

}
