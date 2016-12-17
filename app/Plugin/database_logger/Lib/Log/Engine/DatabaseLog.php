<?php

/**
 * Database logger
 * @author Nick Baker 
 * @version 1.0
 * @license MIT

  # Setup

  in app/config/bootstrap.php add the following

  CakeLog::config('database', array(
  'engine' => 'DatabaseLogger.DatabaseLogger',
  'model' => 'CustomLogModel' //'DatabaseLogger.Log' by default
  ));

 */
App::uses('ClassRegistry', 'Utility');
App::uses('CakeLogInterface', 'Log');
App::uses('Log', 'DatabaseLogger.Model');
App::uses('AppController', 'Controller');

class DatabaseLog implements CakeLogInterface {

    /**
     * Model name placeholder
     */
    var $model = null;

    /**
     * Model object placeholder
     */
    var $Log = null;

    /**
     * Contruct the model class
     */
    function __construct($options = array()) {
        $this->model = isset($options['model']) ? $options['model'] : 'DatabaseLogger.Log';
        $this->Log = ClassRegistry::init($this->model);
    }

    /**
     * Write the log to database
     */
    function write($type, $message) {
        error_reporting(0);
        if ($type=='error') {
            $this->Log->create();
            $this->Log->save(array(
                'model' => $this->_getCurrentModel(),
                'time' => date("Y-m-d H:i:s"),
                'entity' => $this->_getCurrentModelId(),
                'type' => $type,
                'user_id' => $_SESSION['Auth']['User']['id'],
                'url' => $this->_getUrl(),
                'message' => $message
            ));
        }else{
            return true;
        }
    }

    private function _getCurrentModel() {
        App::uses('AppController', 'Controller');
        $params = new Controller();
        $d = explode("/", $_SERVER['REQUEST_URI']);
        $model = Inflector::singularize($d[2]);
        return $model;
    }

    private function _getCurrentModelId() {
        App::uses('AppController', 'Controller');
        $params = new Controller();
        $d = explode("/", $_SERVER['REQUEST_URI']);
        if (isset($d[4])) {
            return $d[4];
        } else {
            return 0;
        }
    }

    private function _getUrl() {
        return 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    }

}
