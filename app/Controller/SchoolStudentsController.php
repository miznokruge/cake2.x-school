<?php
App::uses('AppController', 'Controller');
/**
 * SchoolStudents Controller
 *
 * @property SchoolStudent $SchoolStudent
 * @property PaginatorComponent $Paginator
 */
class SchoolStudentsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
* index method
*
* @return void
*/
public function index() {

$cond='';
if ($this->request->query) {
$cond=$this->request->query['search'];
$this->Paginator->settings = array(
'conditions' =>array('SchoolStudent.name LIKE ' => "$cond%"),
'limit' => 20
);
}
$this->set('search_term',$cond);
$this->SchoolStudent->recursive = 0;
$this->set('schoolStudents', $this->Paginator->paginate());
}

/**
* view method
*
* @throws NotFoundException
* @param string $id
* @return void
*/
public function view($id = null) {
if (!$this->SchoolStudent->exists($id)) {
throw new NotFoundException(__('Invalid school student'));
}
$options = array('conditions' => array('SchoolStudent.' . $this->SchoolStudent->primaryKey => $id));
$this->set('schoolStudent', $this->SchoolStudent->find('first', $options));
}

/**
* add method
*
* @return void
*/
public function add() {
if ($this->request->is('post')) {
$this->SchoolStudent->create();
if ($this->SchoolStudent->save($this->request->data)) {
    $this->Session->setFlash(__('The school student has been saved.'));
    return $this->redirect(array('action' => 'index'));
    } else {
    $this->Session->setFlash(__('The school student could not be saved. Please, try again.'));
}
}
		$schoolClasses = $this->SchoolStudent->SchoolClass->find('list');
		$this->set(compact('schoolClasses'));
}

/**
* edit method
*
* @throws NotFoundException
* @param string $id
* @return void
*/
public function copy($id = null) {
if (!$this->SchoolStudent->exists($id)) {
throw new NotFoundException(__('Invalid school student'));
}
if ($this->request->is(array('post', 'put'))) {
$this->SchoolStudent->create();
if ($this->SchoolStudent->save($this->request->data)) {
    $this->Session->setFlash(__('The school student has been saved.'));
    return $this->redirect(array('action' => 'index'));
    } else {
    $this->Session->setFlash(__('The school student could not be saved. Please, try again.'));
}
} else {
$options = array('conditions' => array('SchoolStudent.' . $this->SchoolStudent->primaryKey => $id));
$this->request->data = $this->SchoolStudent->find('first', $options);
}
		$schoolClasses = $this->SchoolStudent->SchoolClass->find('list');
		$this->set(compact('schoolClasses'));
}


public function edit($id = null) {
if (!$this->SchoolStudent->exists($id)) {
throw new NotFoundException(__('Invalid school student'));
}
if ($this->request->is(array('post', 'put'))) {
if ($this->SchoolStudent->save($this->request->data)) {
    $this->Session->setFlash(__('The school student has been saved.'));
    return $this->redirect(array('action' => 'index'));
    } else {
    $this->Session->setFlash(__('The school student could not be saved. Please, try again.'));
}
} else {
$options = array('conditions' => array('SchoolStudent.' . $this->SchoolStudent->primaryKey => $id));
$this->request->data = $this->SchoolStudent->find('first', $options);
}
		$schoolClasses = $this->SchoolStudent->SchoolClass->find('list');
		$this->set(compact('schoolClasses', 'schoolClasses'));
}

/**
* delete method
*
* @throws NotFoundException
* @param string $id
* @return void
*/
public function delete($id = null) {
$this->SchoolStudent->id = $id;
if (!$this->SchoolStudent->exists()) {
throw new NotFoundException(__('Invalid school student'));
}
$this->request->allowMethod('post', 'delete');
if ($this->SchoolStudent->delete()) {
    $this->Session->setFlash(__('The school student has been deleted.'));
    } else {
    $this->Session->setFlash(__('The school student could not be deleted. Please, try again.'));
    }
    return $this->redirect(array('action' => 'index'));
}
}
