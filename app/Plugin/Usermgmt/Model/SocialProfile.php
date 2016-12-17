<?php

App::uses('UserAuthComponent', 'Controller/Component');

class SocialProfile extends AppModel {

    public $belongsTo = 'User';
    public $hasMany = array(
        'SocialProfile' => array(
            'className' => 'SocialProfile',
        )
    );

}

?>