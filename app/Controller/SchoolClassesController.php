<?php
App::uses('AppController', 'Controller');
/**
 * SchoolClasses Controller
 *
 * @property SchoolClass $SchoolClass
 * @property PaginatorComponent $Paginator
 */
class SchoolClassesController extends AppController {

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
'conditions' =>array('SchoolClass.name LIKE ' => "$cond%"),
'limit' => 20
);
}
$this->set('search_term',$cond);
$this->SchoolClass->recursive = 0;
$this->set('schoolClasses', $this->Paginator->paginate());
}

/**
* view method
*
* @throws NotFoundException
* @param string $id
* @return void
*/
public function view($id = null) {
if (!$this->SchoolClass->exists($id)) {
throw new NotFoundException(__('Invalid school class'));
}
$options = array('conditions' => array('SchoolClass.' . $this->SchoolClass->primaryKey => $id));
$this->set('schoolClass', $this->SchoolClass->find('first', $options));
}

/**
* add method
*
* @return void
*/
public function add() {
if ($this->request->is('post')) {
$this->SchoolClass->create();
if ($this->SchoolClass->save($this->request->data)) {
    $this->Session->setFlash(__('The school class has been saved.'));
    return $this->redirect(array('action' => 'index'));
    } else {
    $this->Session->setFlash(__('The school class could not be saved. Please, try again.'));
}
}
		$schoolTeachers = $this->SchoolClass->SchoolTeacher->find('list');
		$this->set(compact('schoolTeachers'));
}

/**
* edit method
*
* @throws NotFoundException
* @param string $id
* @return void
*/
public function copy($id = null) {
if (!$this->SchoolClass->exists($id)) {
throw new NotFoundException(__('Invalid school class'));
}
if ($this->request->is(array('post', 'put'))) {
$this->SchoolClass->create();
if ($this->SchoolClass->save($this->request->data)) {
    $this->Session->setFlash(__('The school class has been saved.'));
    return $this->redirect(array('action' => 'index'));
    } else {
    $this->Session->setFlash(__('The school class could not be saved. Please, try again.'));
}
} else {
$options = array('conditions' => array('SchoolClass.' . $this->SchoolClass->primaryKey => $id));
$this->request->data = $this->SchoolClass->find('first', $options);
}
		$schoolTeachers = $this->SchoolClass->SchoolTeacher->find('list');
		$this->set(compact('schoolTeachers'));
}


public function edit($id = null) {
if (!$this->SchoolClass->exists($id)) {
throw new NotFoundException(__('Invalid school class'));
}
if ($this->request->is(array('post', 'put'))) {
if ($this->SchoolClass->save($this->request->data)) {
    $this->Session->setFlash(__('The school class has been saved.'));
    return $this->redirect(array('action' => 'index'));
    } else {
    $this->Session->setFlash(__('The school class could not be saved. Please, try again.'));
}
} else {
$options = array('conditions' => array('SchoolClass.' . $this->SchoolClass->primaryKey => $id));
$this->request->data = $this->SchoolClass->find('first', $options);
}
		$schoolTeachers = $this->SchoolClass->SchoolTeacher->find('list');
		$this->set(compact('schoolTeachers', 'schoolTeachers'));
}

/**
* delete method
*
* @throws NotFoundException
* @param string $id
* @return void
*/
public function delete($id = null) {
$this->SchoolClass->id = $id;
if (!$this->SchoolClass->exists()) {
throw new NotFoundException(__('Invalid school class'));
}
$this->request->allowMethod('post', 'delete');
if ($this->SchoolClass->delete()) {
    $this->Session->setFlash(__('The school class has been deleted.'));
    } else {
    $this->Session->setFlash(__('The school class could not be deleted. Please, try again.'));
    }
    return $this->redirect(array('action' => 'index'));
}
}
