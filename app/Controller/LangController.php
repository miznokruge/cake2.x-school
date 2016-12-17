<?php

App::uses('AppController', 'Controller');

/**
 * Messages Controller
 *
 * @property Message $Message
 */
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class LangController extends AppController {

    var $uses = array();

    public function index() {
        $this->redirect('/');
    }

    public function setlang($lang) {
        $this->Session->delete('Config.language');
        $this->Session->write('Config.language', $lang);
        $this->redirect($this->referer());
    }

}
