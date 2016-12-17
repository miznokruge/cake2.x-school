<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PagesController extends AppController {

    public $components = array("Paginator");
    var $uses = array();

    public function index() {

    }

    public function icon() {

    }

    public function invoice() {

    }

    public function help() {
        $this->loadModel('Faq');
        $this->set('faqs', $this->Faq->find("all"));
    }

    public function faq() {

    }

    public function check_updates() {

    }

    public function about() {

    }

    public function board() {

    }

}
