<?php
App::uses('AppController', 'Controller');
class MealsController extends AppController {
	public $layout = 'BootstrapCake.bootstrap';

	public $components = array('Paginator', 'Session');


	public function admin_index() {
		$this->Meal->recursive = 0;
		$this->set('meals', $this->Paginator->paginate());
	}

	public function admin_reorder() {
		if ($this->request->is('post')) {
			$this->Meal->saveMany($this->request->data);
			exit();
		}
		$this->set('meals', $this->Meal->find('all'));
	}

	public function admin_view($id = null) {
		if (!$this->Meal->exists($id)) {
			throw new NotFoundException(__('Invalid meal'));
		}
		$options = array('conditions' => array('Meal.' . $this->Meal->primaryKey => $id));
		$this->set('meal', $this->Meal->find('first', $options));
	}

	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Meal->create();
			if ($this->Meal->save($this->request->data)) {
				$this->Session->setFlash(__('The meal has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The meal could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
	}

	public function admin_edit($id = null) {
		if (!$this->Meal->exists($id)) {
			throw new NotFoundException(__('Invalid meal'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Meal->save($this->request->data)) {
				$this->Session->setFlash(__('The meal has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The meal could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Meal.' . $this->Meal->primaryKey => $id));
			$this->request->data = $this->Meal->find('first', $options);
		}
	}

	public function admin_delete($id = null) {
		$this->Meal->id = $id;
		if (!$this->Meal->exists()) {
			throw new NotFoundException(__('Invalid meal'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Meal->delete()) {
			$this->Session->setFlash(__('The meal has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The meal could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
