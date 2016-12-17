<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AccountingComponent extends Component {

    function initialize(Controller $controller) {
        $this->controller = $controller;
    }

    function startup(Controller $controller = null) {

    }

    function getCurrentPeriod($field) {
        $this->Period = ClassRegistry::init('Period');
        $res = $this->Period->find('first', array('conditions' => array('Period.active' => 1)));
        return $res['Period'][$field];
    }

}
