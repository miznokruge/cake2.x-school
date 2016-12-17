<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ArrayHelper
 *
 * @author user
 */
class InfoHelper extends AppHelper {

    public function __construct(View $view, $settings = array()) {
        parent::__construct($view, $settings);
    }

    public function app($s) {
        App::import("Model", "Config");
        $model = new Config();
        $res = $model->find('first');
        return $res['Config'][$s];
    }

    public function application($s) {
        App::import("Model", "Config");
        $model = new Config();
        $res = $model->find('all');
        $config = array();
        foreach ($res as $x => $imin) {
            $config[$imin['Config']['nama']] = $imin['Config']['keterangan'];
        }
        return $config[$s];
    }

    public function group($id = null, $f = null) {
        App::import("Model", "Group");
        $model = new Group();
        $res = $model->find('first', array("conditions" => array('id' => $id)));
        return $res['Group'][$f];
    }

    public function userdata($id = null, $f = null) {
        App::import("Model", "User");
        $model = new User();
        $res = $model->find('first', array("conditions" => array('User.id' => $id)));
        return $res['User'][$f];
    }

}
