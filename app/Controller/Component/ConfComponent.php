<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ConfComponent extends Component {

    function initialize(Controller $controller) {
        $this->controller = $controller;
    }

    function startup(Controller $controller = null) {

    }

    function getVar($field) {
        $this->Config = ClassRegistry::init('Config');
        $res = $this->Config->find('first', array('conditions' => array('Config.nama' => $field)));
        return $res['Config']['keterangan'];
    }

}
