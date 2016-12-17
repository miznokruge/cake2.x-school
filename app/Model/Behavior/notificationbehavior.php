<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class NotificationBehavior extends ModelBehavior {

    var $default = array(
        'afterSave' => true,
        'afterUpdate' => true,
        'modelName' => '',
        'id' => 'id',
        'user_id' => 'user_id'
    );

    public function setup(&$Model, $settings) {
        $this->default['modelName'] = strtolower($Model->name);
        $this->settings = array_merge($this->default, $settings);
    }

    public function afterSave(&$Model, $created = null) {
        if ($created && $this->settings['afterSave']) {
            $data = $Model->data[$Model->name];
            $this->data['Notification']['user_id'] = $data[$this->settings['user_id']];
            $this->data['Notification'][$this->settings['modelName'] . '_id'] = $data[$this->settings['id']];
        } else if (!$created && $this->settings['afterUpdate']) {
            $data = $Model->data[$Model->name];
            $this->data['Notification']['user_id'] = $data[$this->settings['user_id']];
            $this->data['Notification'][$this->settings['modelName'] . '_id'] = $data[$this->settings['id']];
            $this->data['Notification']['update'] = 1;
        }

        if (!empty($this->data['Notification']['user_id'])) {
            App::import('Model', 'Notification');
            $notification = new Notification;
            $notification->create();
            $notification->save($this->data);
        }
    }

}

?>
