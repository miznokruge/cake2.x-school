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

class UserMgmtAppController extends AppController {

    public $components = array('Session', 'Paginator');
    public $helpers = array('Paginator');

    public function beforeFilter() {
        parent::beforeFilter();

        $this->loadModel('Message');
        $this->loadModel('Notification');
        $this->set('message_inbox', $this->Message->find('all', array(
                    'conditions' => array('Message.sendto_id' => $this->UserAuth->getUserId(), 'Message.is_read' => 0),
                    'order' => 'Message.created DESC',
                    'limit' => 10
        )));
        $this->set('notification_inbox', $this->Notification->find('all', array(
                    'conditions' => array('Notification.user_id' => $this->UserAuth->getUserId(), 'Notification.isread' => 0),
                    'order' => 'Notification.created DESC',
                    'limit' => 10
        )));
        $lang = $this->Session->read('Config.language');
        if ($lang == '') {
            Configure::write('Config.language', 'ind');
            $this->set("current_language", 'ind');
        } else {
            Configure::write('Config.language', $this->Session->read('Config.language'));
            $this->set("current_language", $this->Session->read('Config.language'));
        }
    }

}
