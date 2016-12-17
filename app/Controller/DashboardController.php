<?php

App::uses('AppController', 'Controller');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MenusController
 *
 * @author user
 */
class DashboardController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        if (!$this->UserAuth->isLogged()) {
            $this->redirect('/login');
        }
    }

    public function index() {

    }

    public function index4() {

    }

    public function index3() {

    }

    public function index2() {

    }

    public function about() {

    }

    public function home() {

    }

}
