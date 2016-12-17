<?php

App::uses('Controller', 'Controller');

class AppController extends Controller {

    public $helpers = array('Session', 'Html', 'Form', 'Javascript', 'Ajax', 'Util', 'Array', 'Access', 'Info', 'Time', 'UserAuth', 'Js', 'Html' => array('className' => 'BoostCake.BoostCakeHtml'),
        'Form' => array('className' => 'BoostCake.BoostCakeForm'), 'Paginator' => array('className' => 'BoostCake.BoostCakePaginator'));
    public $components = array('Session', 'UserAuth', 'RequestHandler', 'Util', 'Ctrl', 'Notify', 'Access', 'Conf', 'Accounting');

    public function afterFilter() {
        parent::afterFilter();
        return $this->Session->delete('Message.flash');
    }

    public function beforeFilter() {
        $this->userAuth();

        $this->Session->delete('theme');
//        if (!$this->UserAuth->isLogged()) {
//            $this->layout = 'login_front';
//            $this->loadModel('ComBackground');
//            $this->set('backgrounds', $this->ComBackground->find("all", array('conditions' => array('ComBackground.isactive' => 1))));
//        }
        #get message

        if ($this->UserAuth->LoggedIn()) {
            $this->loadModel('Message');
            $this->loadModel('Notification');
            $this->set('message_inbox', $this->Message->find('all', array(
                        'conditions' => array('Message.sendto_id' => $this->UserAuth->getUserId(), 'Message.is_read' => 0),
                        'order' => 'Message.created DESC',
                        'limit' => 20
            )));
            $this->set('notification_inbox', $this->Notification->find('all', array(
                        'conditions' => array('Notification.user_id' => $this->UserAuth->getUserId(), 'Notification.isread' => 0),
                        'order' => 'Notification.created DESC',
                        'limit' => 20
            )));
        } else {
            $this->layout = 'login';
        }
        $lang = $this->Session->read('Config.language');
        if ($lang == '') {
            Configure::write('Config.language', 'ind');
            $this->set("current_language", 'ind');
        } else {
            Configure::write('Config.language', $this->Session->read('Config.language'));
            $this->set("current_language", $this->Session->read('Config.language'));
        }
    }

    public function beforeRender() {
        if ($this->UserAuth->LoggedIn()) {
            #get menu configuration
            $this->loadModel('Menu');
            $menus = $this->Menu->find('threaded', array('order' => 'Menu.order_row'));
            $this->set(compact('menus'));
        }
    }

    public function isAuthorized($user) {
//        if (isset($user['role']) && $user['role'] === 'admin') {
        return true; //Admin can access every action
//        }
    }

    /* public function afterFilter()
      {
      if( $this instanceof IAccountable && $this->_getJumlah() !== NULL)
      {
      print_r( $this->_getJumlah() );
      }
      } */

    private function _setLanguage() {
        //if the cookie was previously set, and Config.language has not been set
        //write the Config.language with the value from the Cookie
        if ($this->Cookie->read('lang') && !$this->Session->check('Config.language')) {
            $this->Session->write('Config.language', $this->Cookie->read('lang'));
        }
        //if the user clicked the language URL
        else if (isset($this->params['language']) &&
                ($this->params['language'] != $this->Session->read('Config.language'))
        ) {
            //then update the value in Session and the one in Cookie
            $this->Session->write('Config.language', $this->params['language']);
            $this->Cookie->write('lang', $this->params['language'], false, '20 days');
        }
    }

    private function userAuth() {
        $this->UserAuth->beforeFilter($this);
    }

}
