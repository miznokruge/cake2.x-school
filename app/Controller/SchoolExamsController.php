<?php
App::uses('AppController', 'Controller');
/**
 * SchoolExams Controller
 *
 * @property SchoolExam $SchoolExam
 * @property PaginatorComponent $Paginator
 */
class SchoolExamsController extends AppController {

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
'conditions' =>array('SchoolExam.name LIKE ' => "$cond%"),
'limit' => 20
);
}
$this->set('search_term',$cond);
$this->SchoolExam->recursive = 0;
$this->set('schoolExams', $this->Paginator->paginate());
}

/**
* view method
*
* @throws NotFoundException
* @param string $id
* @return void
*/
public function view($id = null) {
if (!$this->SchoolExam->exists($id)) {
throw new NotFoundException(__('Invalid school exam'));
}
$options = array('conditions' => array('SchoolExam.' . $this->SchoolExam->primaryKey => $id));
$this->set('schoolExam', $this->SchoolExam->find('first', $options));
}

/**
* add method
*
* @return void
*/
public function add() {
if ($this->request->is('post')) {
$this->SchoolExam->create();
if ($this->SchoolExam->save($this->request->data)) {
    $this->Session->setFlash(__('The school exam has been saved.'));
    return $this->redirect(array('action' => 'index'));
    } else {
    $this->Session->setFlash(__('The school exam could not be saved. Please, try again.'));
}
}
		$schoolStudents = $this->SchoolExam->SchoolStudent->find('list');
		$schoolSubjects = $this->SchoolExam->SchoolSubject->find('list');
		$this->set(compact('schoolStudents', 'schoolSubjects'));
}

/**
* edit method
*
* @throws NotFoundException
* @param string $id
* @return void
*/
public function copy($id = null) {
if (!$this->SchoolExam->exists($id)) {
throw new NotFoundException(__('Invalid school exam'));
}
if ($this->request->is(array('post', 'put'))) {
$this->SchoolExam->create();
if ($this->SchoolExam->save($this->request->data)) {
    $this->Session->setFlash(__('The school exam has been saved.'));
    return $this->redirect(array('action' => 'index'));
    } else {
    $this->Session->setFlash(__('The school exam could not be saved. Please, try again.'));
}
} else {
$options = array('conditions' => array('SchoolExam.' . $this->SchoolExam->primaryKey => $id));
$this->request->data = $this->SchoolExam->find('first', $options);
}
		$schoolStudents = $this->SchoolExam->SchoolStudent->find('list');
		$schoolSubjects = $this->SchoolExam->SchoolSubject->find('list');
		$this->set(compact('schoolStudents', 'schoolSubjects'));
}


public function edit($id = null) {
if (!$this->SchoolExam->exists($id)) {
throw new NotFoundException(__('Invalid school exam'));
}
if ($this->request->is(array('post', 'put'))) {
if ($this->SchoolExam->save($this->request->data)) {
    $this->Session->setFlash(__('The school exam has been saved.'));
    return $this->redirect(array('action' => 'index'));
    } else {
    $this->Session->setFlash(__('The school exam could not be saved. Please, try again.'));
}
} else {
$options = array('conditions' => array('SchoolExam.' . $this->SchoolExam->primaryKey => $id));
$this->request->data = $this->SchoolExam->find('first', $options);
}
		$schoolStudents = $this->SchoolExam->SchoolStudent->find('list');
		$schoolSubjects = $this->SchoolExam->SchoolSubject->find('list');
		$this->set(compact('schoolStudents', 'schoolSubjects', 'schoolStudents', 'schoolSubjects'));
}

/**
* delete method
*
* @throws NotFoundException
* @param string $id
* @return void
*/
public function delete($id = null) {
$this->SchoolExam->id = $id;
if (!$this->SchoolExam->exists()) {
throw new NotFoundException(__('Invalid school exam'));
}
$this->request->allowMethod('post', 'delete');
if ($this->SchoolExam->delete()) {
    $this->Session->setFlash(__('The school exam has been deleted.'));
    } else {
    $this->Session->setFlash(__('The school exam could not be deleted. Please, try again.'));
    }
    return $this->redirect(array('action' => 'index'));
}
}
