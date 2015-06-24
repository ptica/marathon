<?php
App::uses('AppController', 'Controller');
class QueriesController extends AppController {
	public $layout = 'BootstrapCake.bootstrap';

	public $components = array('Paginator', 'Session');


	public function admin_index() {
		$this->Query->recursive = 0;
		$this->set('queries', $this->Paginator->paginate());
	}

	public function admin_reorder() {
		if ($this->request->is('post')) {
			$this->Query->saveMany($this->request->data);
			exit();
		}
		$this->set('queries', $this->Query->find('all'));
	}

	public function admin_view($id = null) {
		if (!$this->Query->exists($id)) {
			throw new NotFoundException(__('Invalid query'));
		}
		$options = array('conditions' => array('Query.' . $this->Query->primaryKey => $id));
		$this->set('query', $this->Query->find('first', $options));
	}

	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Query->create();
			if ($this->Query->save($this->request->data)) {
				$this->Session->setFlash(__('The query has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The query could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
	}

	public function admin_edit($id = null) {
		if (!$this->Query->exists($id)) {
			throw new NotFoundException(__('Invalid query'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Query->save($this->request->data)) {
				$this->Session->setFlash(__('The query has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The query could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Query.' . $this->Query->primaryKey => $id));
			$this->request->data = $this->Query->find('first', $options);
		}
	}

	public function admin_delete($id = null) {
		$this->Query->id = $id;
		if (!$this->Query->exists()) {
			throw new NotFoundException(__('Invalid query'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Query->delete()) {
			$this->Session->setFlash(__('The query has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The query could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
