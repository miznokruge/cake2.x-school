<?php

App::uses('AppModel', 'Model');

/**
 * Income Model
 *
 * @property Bank $Bank
 * @property BankTrans $BankTrans
 * @property Rekap $Rekap
 */
class Notification extends AppModel {

    public $actsAs = array();
    public $belongTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        )
    );

}
