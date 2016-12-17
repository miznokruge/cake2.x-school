<?php
App::uses('AppModel', 'Model');
/**
 * SchoolExam Model
 *
 * @property SchoolStudent $SchoolStudent
 * @property SchoolSubject $SchoolSubject
 */
class SchoolExam extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'school_student_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'school_subject_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'score' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'SchoolStudent' => array(
			'className' => 'SchoolStudent',
			'foreignKey' => 'school_student_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'SchoolSubject' => array(
			'className' => 'SchoolSubject',
			'foreignKey' => 'school_subject_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
