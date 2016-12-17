<?php

App::uses('AppController', 'Controller');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MenusController
 *
 * @author user
 */
class MenusController extends AppController {

    public $helpers = array('javascript', 'html');
    public $components = array(
        'Arr', 'Util'
    );

    public function index() {
        $menus = $this->Menu->find('threaded', array('order' => 'Menu.order_row ASC'));

        //include treegrid
        $this->set('cssIncludes', array('jquery.treegrid.css'));
        $this->set('jsIncludes', array('jquery.treegrid.js'));
        $this->set('menus', $menus);
    }

    public function add() {
        if ($this->request->is('post') && $this->request->is('ajax')) {
            $response = array('Result' => "OK", 'Message' => 'Success');
            $data = $this->request->data;
            $parent_id = $this->Arr->get($data, 'parent_id');
            if ((int) $parent_id == 0)
                $parent_id = NULL;
            $this->Menu->set('parent_id', $parent_id);
            $this->Menu->set('name', $this->Util->space2underscore($this->Arr->get($data, 'label')));
            $this->Menu->set('label', $this->Arr->get($data, 'label'));

            $controller = $this->Arr->get($data, 'controller');
            $this->Menu->set('controller', $controller);

            $action = $this->Arr->get($data, 'action');
            if (!empty($controller) && !$action)
                $action = 'index';
            $this->Menu->set('action', $action);
            $this->Menu->set('icon', $this->Arr->get($data, 'icon'));
            $this->Menu->set('order_row', $this->Arr->get($data, 'order', 99));
            try {
                $this->Menu->save();
                $response['Menu'] = $this->Menu;
            } catch (Exception $e) {
                $response['Result'] = "ERROR";
                $response['Message'] = 'Ooops..something went wrong, please contact IT.<br>' . $e->getMessage();
            }
            $this->response->body(json_encode($response));
            return $this->response;
        } else {
            throw new NotFoundException('Oooops..');
        }
    }

    public function update() {
        if ($this->request->is('post') && $this->request->is('ajax')) {
            $response = array('Result' => "OK", 'Message' => 'Success');
            $data = $this->request->data;
            if (!is_numeric($this->Arr->get($data, 'menu_id'))) {
                $response['Result'] = "ERROR";
                $response['Message'] = 'Ooops.. Bad request.';
                echo json_encode($response);
                exit;
            }

            $this->Menu->id = $this->Arr->get($data, 'menu_id');
            $parent_id = $this->Arr->get($data, 'parent_id');
            if ((int) $parent_id == 0)
                $parent_id = NULL;
            $this->Menu->set('parent_id', $parent_id);

            $this->Menu->set('name', $this->Util->space2underscore($this->Arr->get($data, 'label')));
            $this->Menu->set('label', $this->Arr->get($data, 'label'));

            $controller = $this->Arr->get($data, 'controller');
            $this->Menu->set('controller', $controller);

            $action = $this->Arr->get($data, 'action');
            if (!empty($controller) && !$action)
                $action = 'index';
            $this->Menu->set('action', $action);

            $this->Menu->set('icon', $this->Arr->get($data, 'icon'));
            $this->Menu->set('enabled', $this->Arr->get($data, 'enabled'));

            try {
                $this->Menu->save();
                $response['Menu'] = $this->Menu;
            } catch (Exception $e) {
                $response['Result'] = "ERROR";
                $response['Message'] = 'Ooops..something went wrong, please contact IT.<br>' . $e->getMessage();
            }
            $this->response->body(json_encode($response));
            return $this->response;
        } else {
            throw new NotFoundException('Oooops..');
        }
    }

    public function remove() {
        if ($this->request->is('post') && $this->request->is('ajax')) {
            $response = array('Result' => "OK", 'Message' => 'Success'); //default ajax response
            $data = $this->request->data;
            $menu_id = $this->Arr->get($data, 'menu_id');

            if (!is_numeric($menu_id)) {
                $response['Result'] = "ERROR";
                $response['Message'] = 'Ooops.. Bad request.';
                echo json_encode($response);
                exit;
            }

            $this->Menu->query('DELETE FROM menus WHERE id = ' . $menu_id . ' OR parent_id = ' . $menu_id);

            $this->response->body(json_encode($response));
            return $this->response;
        } else {
            throw new MethodNotAllowedException('not allowed method.');
        }
    }

    public function reorder() {
        if ($this->request->is('post') && $this->request->is('ajax')) {
            $response = array('Result' => "OK", 'Message' => 'Success'); //default ajax response
            $data = $this->request->data;

            foreach ($data['key'] as $key => $dt) {
                $this->Menu->id = $dt;
                $this->Menu->set('order_row', $data['order'][$key]);
                $this->Menu->save();
            }

            $this->response->body(json_encode($response));
            return $this->response;
        } else {
            throw new MethodNotAllowedException('not allowed method.');
        }
    }

}
