<?php

class NotifyComponent extends Component {

    public $components = array('Util', 'UserAuth');

    public function toGroup($id, $type = null, $content = null, $url = null) {
        $this->Notification = ClassRegistry::init('Notification');
        $this->User = ClassRegistry::init('User');
        $users = $this->User->find("all", array("conditions" => array("User.user_group_id" => $id)));
        foreach ($users as $u) {
            $n[] = array(
                'user_id' => $u['User']['id'],
                'content' => $content,
                'created' => date("Y-m-d H:i:s"),
                'type' => $type,
                'url' => $url
            );
        }
        $this->Notification->saveAll($n);
    }

    public function toUser($id, $type = null, $content = null, $url = null) {
        App::uses('CakeEmail', 'Network/Email');

        $this->Notification = ClassRegistry::init('Notification');
        $this->User = ClassRegistry::init('User');
        $n = array(
            'user_id' => $id,
            'content' => $content,
            'created' => date("Y-m-d H:i:s"),
            'type' => $type,
            'url' => $url
        );
        $this->Notification->save($n);
        $user = $this->User->read(null, $id);
        $email = new CakeEmail();
        $fromConfig = EMAIL_FROM_ADDRESS;
        $fromNameConfig = EMAIL_FROM_NAME;
        $email->from(array($fromConfig => $fromNameConfig));
        $email->sender(array($fromConfig => $fromNameConfig));
        $email->to($user['User']['email']);
        $email->subject($this->UserAuth->getUserName() . ': Join My Project');
        //$email->transport('Debug');
        $body = $this->request->data['message'];
        $body.="\n\n To login to your account, click here => " . LOGIN_URL;
        $body.=" \n\n Thanks,\n" . EMAIL_FROM_NAME;
        try {
            $result = $email->send($body);
            $this->Util->setFlash('invitation sent', 'success');
        } catch (Exception $ex) {
            // we could not send the email, ignore it
            $result = "Could not send invitation email to userid-" . $userId;
        }
        $this->log($result, LOG_DEBUG);
    }

}
