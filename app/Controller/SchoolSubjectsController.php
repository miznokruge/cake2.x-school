<?php
App::uses('AppController', 'Controller');
/**
 * SchoolSubjects Controller
 *
 * @property SchoolSubject $SchoolSubject
 * @property PaginatorComponent $Paginator
 */
class SchoolSubjectsController extends AppController {

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
'conditions' =>array('SchoolSubject.name LIKE ' => "$cond%"),
'limit' => 20
);
}
$this->set('search_term',$cond);
$this->SchoolSubject->recursive = 0;
$this->set('schoolSubjects', $this->Paginator->paginate());
}

/**
* view method
*
* @throws NotFoundException
* @param string $id
* @return void
*/
public function view($id = null) {
if (!$this->SchoolSubject->exists($id)) {
throw new NotFoundException(__('Invalid school subject'));
}
$options = array('conditions' => array('SchoolSubject.' . $this->SchoolSubject->primaryKey => $id));
$this->set('schoolSubject', $this->SchoolSubject->find('first', $options));
}

/**
* add method
*
* @return void
*/
public function add() {
if ($this->request->is('post')) {
$this->SchoolSubject->create();
if ($this->SchoolSubject->save($this->request->data)) {
    $this->Session->setFlash(__('The school subject has been saved.'));
    return $this->redirect(array('action' => 'index'));
    } else {
    $this->Session->setFlash(__('The school subject could not be saved. Please, try again.'));
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
if (!$this->SchoolSubject->exists($id)) {
throw new NotFoundException(__('Invalid school subject'));
}
if ($this->request->is(array('post', 'put'))) {
$this->SchoolSubject->create();
if ($this->SchoolSubject->save($this->request->data)) {
    $this->Session->setFlash(__('The school subject has been saved.'));
    return $this->redirect(array('action' => 'index'));
    } else {
    $this->Session->setFlash(__('The school subject could not be saved. Please, try again.'));
}
} else {
$options = array('conditions' => array('SchoolSubject.' . $this->SchoolSubject->primaryKey => $id));
$this->request->data = $this->SchoolSubject->find('first', $options);
}
}


public function edit($id = null) {
if (!$this->SchoolSubject->exists($id)) {
throw new NotFoundException(__('Invalid school subject'));
}
if ($this->request->is(array('post', 'put'))) {
if ($this->SchoolSubject->save($this->request->data)) {
    $this->Session->setFlash(__('The school subject has been saved.'));
    return $this->redirect(array('action' => 'index'));
    } else {
    $this->Session->setFlash(__('The school subject could not be saved. Please, try again.'));
}
} else {
$options = array('conditions' => array('SchoolSubject.' . $this->SchoolSubject->primaryKey => $id));
$this->request->data = $this->SchoolSubject->find('first', $options);
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
$this->SchoolSubject->id = $id;
if (!$this->SchoolSubject->exists()) {
throw new NotFoundException(__('Invalid school subject'));
}
$this->request->allowMethod('post', 'delete');
if ($this->SchoolSubject->delete()) {
    $this->Session->setFlash(__('The school subject has been deleted.'));
    } else {
    $this->Session->setFlash(__('The school subject could not be deleted. Please, try again.'));
    }
    return $this->redirect(array('action' => 'index'));
}
}
