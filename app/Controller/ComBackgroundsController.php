<?php
App::uses('AppController', 'Controller');
/**
 * ComBackgrounds Controller
 *
 * @property ComBackground $ComBackground
 */
class ComBackgroundsController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->ComBackground->recursive = 0;
		$this->set('comBackgrounds', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->ComBackground->id = $id;
		if (!$this->ComBackground->exists()) {
			throw new NotFoundException(__('Invalid com background'));
		}
		$this->set('comBackground', $this->ComBackground->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ComBackground->create();
			if ($this->ComBackground->save($this->request->data)) {
				$this->Session->setFlash(__('The com background has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The com background could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->ComBackground->id = $id;
		if (!$this->ComBackground->exists()) {
			throw new NotFoundException(__('Invalid com background'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ComBackground->save($this->request->data)) {
				$this->Session->setFlash(__('The com background has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The com background could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->ComBackground->read(null, $id);
		}
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
		$this->ComBackground->id = $id;
		if (!$this->ComBackground->exists()) {
			throw new NotFoundException(__('Invalid com background'));
		}
		if ($this->ComBackground->delete()) {
			$this->Session->setFlash(__('Com background deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Com background was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
