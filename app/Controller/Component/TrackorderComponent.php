<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TrackorderComponent extends Component {

    public $controller;
    public $action;
    public $components = array('Acl', 'Util', 'Session',
        'Auth' => array(
            'authorize' => array(
                'Actions' => array('actionPath' => 'controllers')
            )
    ));

    function __construct(ComponentCollection $collection, $settings = array()) {
        parent::__construct($collection, $settings);
        $this->Controller = $collection->getController();
    }

    function initialize(Controller $controller) {
        $this->controller = $controller;
    }

    public function createLog($orderId, $post = NULL, $msg = NULL, $status = 1) {
        
        if(isset($post['Full Order Info'])){
            $post['Full Order Info'];
        }else{
            $post['Full Order Info']='';
        }
        
        $track = ClassRegistry::init('Ordertrack');
        $data = array();
        $data['date'] = date("Y-m-d H:i:s");
        $data['controller'] = $this->Controller->params['controller'];
        $data['action'] = $this->Controller->params['action'];
        $data['result'] = json_encode($post['Full Order Info']);
        $data['data'] = json_encode($post);
        $data['keterangan'] =$msg;
        $data['user_id'] = $this->UserAuth->user('id');
        $data['order_id'] = $orderId;
        $data['status'] = $status;
        if ($track->save($data)) {
            return true;
        } else {
            throw new ErrorException('Error saving order tracking.');
        }
    }

}
