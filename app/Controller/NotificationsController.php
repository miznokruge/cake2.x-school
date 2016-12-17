<?php

App::uses('AppController', 'Controller');

/**
 * Notifications Controller
 *
 * @property Notification $Notification
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class NotificationsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');

    /**
     * index method
     *
     * @return void
     */
    public function index() {

        $cond = '';
        if ($this->request->query) {
            $cond = $this->request->query['search'];
            $this->Paginator->settings = array(
                'conditions' => array('Notification.name LIKE ' => "$cond%"),
                'limit' => 20
            );
        }
        $this->set('search_term', $cond);
        $this->Notification->recursive = 0;
        $this->set('notifications', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Notification->exists($id)) {
            throw new NotFoundException(__('Invalid notification'));
        }
        $options = array('conditions' => array('Notification.' . $this->Notification->primaryKey => $id));
        $this->set('notification', $this->Notification->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Notification->create();
            if ($this->Notification->save($this->request->data)) {
                $this->Session->setFlash(__('The notification has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The notification could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Notification->exists($id)) {
            throw new NotFoundException(__('Invalid notification'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Notification->save($this->request->data)) {
                $this->Session->setFlash(__('The notification has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The notification could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Notification.' . $this->Notification->primaryKey => $id));
            $this->request->data = $this->Notification->find('first', $options);
        }
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Notification->id = $id;
        if (!$this->Notification->exists()) {
            throw new NotFoundException(__('Invalid notification'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Notification->delete()) {
            $this->Session->setFlash(__('The notification has been deleted.'));
        } else {
            $this->Session->setFlash(__('The notification could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function get_all() {
        $this->layout = 'ajax';
        $data = $this->Notification->find("all", array(
            'conditions' => array(
            //"Notification.user_id" => $this->UserAuth->getUserId(),
//                "Notification.pushed" => 0
            ),
            'limit' => 1,
            'order' => 'rand()'
        ));
        if ($data) {
            foreach ($data as $d) {
                $x[] = array(
                    'type' => $d['Notification']['type'],
                    'content' => $d['Notification']['content'],
                    'url' => $d['Notification']['url']
                );
                $update['id'] = $d['Notification']['id'];
//                $update['pushed'] = 1;
                $this->Notification->save($update);
            }
            echo json_encode($x);
            die;
        } else {
            echo json_encode(array());
            die;
        }
    }

}
