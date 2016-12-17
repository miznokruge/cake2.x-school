<?php

App::uses('AppModel', 'Model');

/**
 * City Model
 *
 * @property Province $Province
 */
class LoginToken extends AppModel {
    /**
     * Validation rules
     *
     * @var array
     */
    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

}
