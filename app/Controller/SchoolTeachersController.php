<?php
App::uses('AppController', 'Controller');
/**
 * SchoolTeachers Controller
 *
 * @property SchoolTeacher $SchoolTeacher
 * @property PaginatorComponent $Paginator
 */
class SchoolTeachersController extends AppController {

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
'conditions' =>array('SchoolTeacher.name LIKE ' => "$cond%"),
'limit' => 20
);
}
$this->set('search_term',$cond);
$this->SchoolTeacher->recursive = 0;
$this->set('schoolTeachers', $this->Paginator->paginate());
}

/**
* view method
*
* @throws NotFoundException
* @param string $id
* @return void
*/
public function view($id = null) {
if (!$this->SchoolTeacher->exists($id)) {
throw new NotFoundException(__('Invalid school teacher'));
}
$options = array('conditions' => array('SchoolTeacher.' . $this->SchoolTeacher->primaryKey => $id));
$this->set('schoolTeacher', $this->SchoolTeacher->find('first', $options));
}

/**
* add method
*
* @return void
*/
public function add() {
if ($this->request->is('post')) {
$this->SchoolTeacher->create();
if ($this->SchoolTeacher->save($this->request->data)) {
    $this->Session->setFlash(__('The school teacher has been saved.'));
    return $this->redirect(array('action' => 'index'));
    } else {
    $this->Session->setFlash(__('The school teacher could not be saved. Please, try again.'));
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
public function copy($id = null) {
if (!$this->SchoolTeacher->exists($id)) {
throw new NotFoundException(__('Invalid school teacher'));
}
if ($this->request->is(array('post', 'put'))) {
$this->SchoolTeacher->create();
if ($this->SchoolTeacher->save($this->request->data)) {
    $this->Session->setFlash(__('The school teacher has been saved.'));
    return $this->redirect(array('action' => 'index'));
    } else {
    $this->Session->setFlash(__('The school teacher could not be saved. Please, try again.'));
}
} else {
$options = array('conditions' => array('SchoolTeacher.' . $this->SchoolTeacher->primaryKey => $id));
$this->request->data = $this->SchoolTeacher->find('first', $options);
}
}


public function edit($id = null) {
if (!$this->SchoolTeacher->exists($id)) {
throw new NotFoundException(__('Invalid school teacher'));
}
if ($this->request->is(array('post', 'put'))) {
if ($this->SchoolTeacher->save($this->request->data)) {
    $this->Session->setFlash(__('The school teacher has been saved.'));
    return $this->redirect(array('action' => 'index'));
    } else {
    $this->Session->setFlash(__('The school teacher could not be saved. Please, try again.'));
}
} else {
$options = array('conditions' => array('SchoolTeacher.' . $this->SchoolTeacher->primaryKey => $id));
$this->request->data = $this->SchoolTeacher->find('first', $options);
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
$this->SchoolTeacher->id = $id;
if (!$this->SchoolTeacher->exists()) {
throw new NotFoundException(__('Invalid school teacher'));
}
$this->request->allowMethod('post', 'delete');
if ($this->SchoolTeacher->delete()) {
    $this->Session->setFlash(__('The school teacher has been deleted.'));
    } else {
    $this->Session->setFlash(__('The school teacher could not be deleted. Please, try again.'));
    }
    return $this->redirect(array('action' => 'index'));
}
}
