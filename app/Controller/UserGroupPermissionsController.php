<?php

/*
  This file is part of UserMgmt.

  Author: Chetan Varshney (http://ektasoftwares.com)

  UserMgmt is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  UserMgmt is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
 */
App::uses('AppController', 'Controller');

class UserGroupPermissionsController extends AppController {

    public $components = array("ControllerList");

    /**
     * Used to display all permissions of site by Admin
     *
     * @access public
     * @return array
     */
    public function index() {
        $c = -2;
        if (isset($_GET['c']) && $_GET['c'] != '') {
            $c = $_GET['c'];
        }
        $this->set('c', $c);
        $allControllers = $this->ControllerList->getControllers();
        $this->set('allControllers', $allControllers);
        if ($c > -2) {
            $con = array();
            $conAll = $this->ControllerList->get();
            if ($c == -1) {
                $con = $conAll;
                $user_group_permissions = $this->UserGroupPermission->find('all', array('order' => array('controller', 'action')));
            } else {
                $user_group_permissions = $this->UserGroupPermission->find('all', array('order' => array('controller', 'action'), 'conditions' => array('controller' => $allControllers[$c])));
                $con[$allControllers[$c]] = (isset($conAll[$allControllers[$c]])) ? $conAll[$allControllers[$c]] : array();
            }
            foreach ($user_group_permissions as $row) {
                $cont = $row['UserGroupPermission']['controller'];
                $act = $row['UserGroupPermission']['action'];
                $ugname = $row['UserGroup']['alias_name'];
                $allowed = $row['UserGroupPermission']['allowed'];
                $con[$cont][$act][$ugname] = $allowed;
            }
            $this->set('controllers', $con);
            $this->loadModel('UserGroup');
            $result = $this->UserGroup->getGroupNamesAndIds();
            $groups = array();
            $groups2 = array();
            foreach ($result as $row) {
                $groups[] = $row['alias_name'];
            }
            $groups = implode(',', $groups);
            $this->set('user_groups', $result);
            $this->set('groups', $groups);
        }
        $this->set('js', array('umupdate'));
    }

    /**
     *  Used to update permissions of site using Ajax by Admin
     *
     * @access public
     * @return integer
     */
    public function update() {
        $this->loadModel('UserGroup');
        $this->autoRender = false;
        $controller = $this->params['data']['controller'];
        $action = $this->params['data']['action'];
        $result = $this->UserGroup->getGroupNamesAndIds();
        $success = 0;
        foreach ($result as $row) {
            if (isset($this->params['data'][$row['alias_name']])) {
                $res = $this->UserGroupPermission->find('first', array('conditions' => array('controller' => $controller, 'action' => $action, 'user_group_id' => $row['id'])));
                if (empty($res)) {
                    $data = array();
                    $data['UserGroupPermission']['user_group_id'] = $row['id'];
                    $data['UserGroupPermission']['controller'] = $controller;
                    $data['UserGroupPermission']['action'] = $action;
                    $data['UserGroupPermission']['allowed'] = $this->params['data'][$row['alias_name']];
                    $data['UserGroupPermission']['id'] = null;
                    $rtn = $this->UserGroupPermission->save($data);
                    if ($rtn) {
                        $success = 1;
                    }
                } else {
                    if ($this->params['data'][$row['alias_name']] != $res['UserGroupPermission']['allowed']) {
                        $data = array();
                        $data['UserGroupPermission']['allowed'] = $this->params['data'][$row['alias_name']];
                        $data['UserGroupPermission']['id'] = $res['UserGroupPermission']['id'];
                        $rtn = $this->UserGroupPermission->save($data);
                        if ($rtn) {
                            $success = 1;
                        }
                    } else {
                        $success = 1;
                    }
                }
            }
        }
        echo $success;
        $this->__deleteCache();
    }

    public function updateAll() {
        $this->autoRender = false;
        $controller = $this->params['data']['controller'];
        $action = $this->params['data']['action'];
        $result = $this->UserGroup->getGroupNamesAndIds();
        $success = 0;
        foreach ($result as $row) {
            if (isset($this->params['data'][$row['alias_name']])) {
                $res = $this->UserGroupPermission->find('first', array('conditions' => array('controller' => $controller, 'action' => $action, 'user_group_id' => $row['id'])));
                if (empty($res)) {
                    $data = array();
                    $data['UserGroupPermission']['user_group_id'] = $row['id'];
                    $data['UserGroupPermission']['controller'] = $controller;
                    $data['UserGroupPermission']['action'] = $action;
                    $data['UserGroupPermission']['allowed'] = $this->params['data'][$row['alias_name']];
                    $data['UserGroupPermission']['id'] = null;
                    $rtn = $this->UserGroupPermission->save($data);
                    if ($rtn) {
                        $success = 1;
                    }
                } else {
                    if ($this->params['data'][$row['alias_name']] != $res['UserGroupPermission']['allowed']) {
                        $data = array();
                        $data['UserGroupPermission']['allowed'] = $this->params['data'][$row['alias_name']];
                        $data['UserGroupPermission']['id'] = $res['UserGroupPermission']['id'];
                        $rtn = $this->UserGroupPermission->save($data);
                        if ($rtn) {
                            $success = 1;
                        }
                    } else {
                        $success = 1;
                    }
                }
            }
        }
        echo $success;
        $this->__deleteCache();
    }

    /**
     * Used to delete cache of permissions and used when any permission gets changed by Admin
     *
     * @access private
     * @return void
     */
    private function __deleteCache() {
        error_reporting(0);
        $iterator = new RecursiveDirectoryIterator(CACHE);
        foreach (new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST) as $file) {
            $path_info = pathinfo($file);
            if ($path_info['dirname'] == TMP . "cache") {
                if (!is_dir($file->getPathname())) {
                    unlink($file->getPathname());
                }
            }
        }
    }

    public function generate_all_permissions() {
        $cs = $this->Ctrl->get();
        foreach ($cs as $c) {
            $controller = $c['controller'];
            foreach ($c['actions'] as $action) {
                $this->loadModel('UserGroup');
                $result = $this->UserGroup->getGroupNamesAndIds();
                $success = 0;
                foreach ($result as $row) {

                    if ($row['id'] == '1')
                        $allowed = 1;
                    else
                        $allowed = 0;

                    $res = $this->UserGroupPermission->find('first', array('conditions' => array('controller' => $controller, 'action' => $action, 'user_group_id' => $row['id'])));
                    if (empty($res)) {
                        $data = array();
                        $data['UserGroupPermission']['user_group_id'] = $row['id'];
                        $data['UserGroupPermission']['controller'] = $controller;
                        $data['UserGroupPermission']['action'] = $action;
                        $data['UserGroupPermission']['allowed'] = $allowed;
                        $data['UserGroupPermission']['id'] = null;
                        $rtn = $this->UserGroupPermission->save($data);
                        if ($rtn) {
                            $success = 1;
                        }
                    } else {
                        $data = array();
                        $data['UserGroupPermission']['allowed'] = $allowed;
                        $data['UserGroupPermission']['id'] = $res['UserGroupPermission']['id'];
                        $rtn = $this->UserGroupPermission->save($data);
                        if ($rtn) {
                            $success = 1;
                        }
                    }
                }
            }
        }
        echo 'oke... boooooooommmmm';
        exit();
    }

    public function set_group_permission($group_id, $allowed) {
        $cs = $this->Ctrl->get();
        foreach ($cs as $c) {
            $controller = $c['controller'];
            foreach ($c['actions'] as $action) {
                $res = $this->UserGroupPermission->find('first', array('conditions' => array('controller' => $controller, 'action' => $action, 'user_group_id' => $group_id)));
                if (empty($res)) {
                    $data = array();
                    $data['UserGroupPermission']['user_group_id'] = $group_id;
                    $data['UserGroupPermission']['controller'] = $controller;
                    $data['UserGroupPermission']['action'] = $action;
                    $data['UserGroupPermission']['allowed'] = $allowed;
                    $data['UserGroupPermission']['id'] = null;
                    $rtn = $this->UserGroupPermission->save($data);
                    if ($rtn) {
                        $success = 1;
                    }
                } else {
                    $data = array();
                    $data['UserGroupPermission']['allowed'] = $allowed;
                    $data['UserGroupPermission']['id'] = $res['UserGroupPermission']['id'];
                    $rtn = $this->UserGroupPermission->save($data);
                    if ($rtn) {
                        $success = 1;
                    }
                }
            }
        }
        echo 'oke... boooooooommmmm';
        exit();
    }

}
