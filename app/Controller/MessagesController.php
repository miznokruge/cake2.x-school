<?php

App::uses('AppController', 'Controller');

/**
 * Messages Controller
 *
 * @property Message $Message
 */
class MessagesController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function beforeFilter() {
        parent::beforeFilter();

        $this->set('j_inbox', $this->Message->find('count', array(
                    'conditions' => array(
                        'Message.sendto_id' => $this->UserAuth->user('id'),
                        'Message.is_read' => 0,
                        'Message.deleted' => 0
                    )
                        )
        ));
        $this->set('j_draft', $this->Message->find('count', array(
                    'conditions' => array(
                        'Message.user_id' => $this->UserAuth->user('id'),
                        'Message.sent' => 0,
                        'Message.deleted' => 0
                    )
                        )
        ));
    }

    public function index() {
        $this->Message->recursive = 0;
        $this->paginate = array(
            'conditions' => array('Message.sendto_id' => $this->UserAuth->user('id'), 'Message.deleted' => 0),
            'order' => array('Message.is_read asc', 'Message.created desc'),
            'limit' => 10
        );
        $this->set('messages', $this->paginate());
    }

    public function trash() {
        $this->Message->recursive = 0;
        $this->paginate = array(
            'conditions' => array('Message.sendto_id' => $this->UserAuth->user('id'), 'Message.deleted' => 0),
            'order' => array('Message.is_read asc', 'Message.created desc'),
            'limit' => 5
        );
        $this->set('messages', $this->paginate());
    }

    public function draft() {
        $this->Message->recursive = 0;
        $this->paginate = array(
            'conditions' => array(
                'Message.user_id' => $this->UserAuth->user('id'),
                'Message.sent' => 0,
                'Message.deleted' => 0),
        );
        $this->set('messages', $this->paginate());
    }

    public function sent() {
        $this->Message->recursive = 0;
        $this->paginate = array(
            'conditions' => array(
                'Message.user_id' => $this->UserAuth->user('id'),
                'Message.sent' => 1,
                'Message.deleted' => 0),
        );
        $this->set('messages', $this->paginate());
    }

    /**
     * view method
     *
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->Message->id = $id;
        $data['Message']['is_read'] = 1;
        $this->Message->save($data);
        if (!$this->Message->exists()) {
            throw new NotFoundException(__('Invalid message'));
        }
        $this->set('message', $this->Message->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add($user_id = null, $msg_id = null) {
        if ($this->request->is('post')) {
            $data = array();
            foreach ($this->request->data['Message']['sendto_id'] as $sid) {
                $data[] = array(
                    'user_id' => $this->UserAuth->user('id'),
                    'sendto_id' => $sid,
                    'sent' => 1,
                    'subject' => $this->request->data['Message']['subject'],
                    'message' => $this->request->data['Message']['message']
                );
            }

            $this->Message->create();
            if ($this->Message->saveAll($data)) {
                $this->Session->setFlash(__('The message has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The message could not be saved. Please, try again.'));
            }
        }
        $this->loadModel('User');
        $users = $this->User->find('list', array('conditions' => array('User.id !=' => $this->UserAuth->user('id'))));
        $message = $this->Message->read(null, $msg_id);
        $this->set(compact('users', 'user_id', 'message'));
    }

    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->Message->id = $id;
        if (!$this->Message->exists()) {
            throw new NotFoundException(__('Invalid message'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Message->save($this->request->data)) {
                $this->Session->setFlash(__('The message has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The message could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Message->read(null, $id);
        }
        $users = $this->Message->User->find('list');
        $this->set(compact('users'));
    }

    /**
     * delete method
     *
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Message->id = $id;
        if (!$this->Message->exists()) {
            throw new NotFoundException(__('Invalid message'));
        }
        if ($this->Message->delete()) {
            $this->Session->setFlash(__('Message deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Message was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function mark_as_read() {
        $this->layout = 'ajax';
        if ($this->request->is('post')) {
            foreach ($this->request->data['msgs'] as $msg) {
                $x[] = $msg;
                $data['Message']['id'] = $msg;
                $data['Message']['is_read'] = 1;
                $this->Message->save($data);
            }
            echo json_encode($x);
            exit;
        }
    }

    public function move_to_trash() {
        $this->layout = 'ajax';
        if ($this->request->is('post')) {
            foreach ($this->request->data['msgs'] as $msg) {
                $x[] = $msg;
                $data['Message']['id'] = $msg;
                $data['Message']['deleted'] = 1;
                $this->Message->save($data);
            }
            echo json_encode($x);
            exit;
        }
    }

    public function check_unread() {
        $m = $this->Message->find("all", array('conditions' => array('Message.is_read' => 0)));
        foreach ($m as $x) {
            $n[] = array('user' => $x['User']['username'], 'subject' => $x['Message']['subject']);
            $y['Message']['id'] = $x['Message']['id'];
            $y['Message']['dropped'] = 1;
            $this->Message->save($y);
        }
        echo json_encode($n);
        exit();
    }

}
