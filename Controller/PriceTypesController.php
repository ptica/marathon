<?php
App::uses('AppController', 'Controller');
class PriceTypesController extends AppController {
	public $layout = 'BootstrapCake.bootstrap';

	public $components = array('Paginator', 'Session');

	public function admin_reorder() {
		if ($this->request->is('post')) {
			$this->PriceType->saveMany($this->request->data);
			exit();
		}
		$this->set('priceTypes', $this->PriceType->find('all'));
	}

	public function admin_index() {
		$this->PriceType->recursive = 1;
		$this->set('priceTypes', $this->Paginator->paginate());
	}

	public function admin_view($id = null) {
		if (!$this->PriceType->exists($id)) {
			throw new NotFoundException(__('Invalid price type'));
		}
		$options = array('conditions' => array('PriceType.' . $this->PriceType->primaryKey => $id));
		$this->set('priceType', $this->PriceType->find('first', $options));
	}

	public function admin_add() {
		if ($this->request->is('post')) {
			$this->PriceType->create();
			if ($this->PriceType->save($this->request->data)) {
				$this->Session->setFlash(__('The price type has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The price type could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$locations = $this->PriceType->Location->find('list');
		$this->set(compact('locations'));
	}

	public function admin_edit($id = null) {
		if (!$this->PriceType->exists($id)) {
			throw new NotFoundException(__('Invalid price type'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->PriceType->save($this->request->data)) {
				$this->Session->setFlash(__('The price type has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The price type could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('PriceType.' . $this->PriceType->primaryKey => $id));
			$this->request->data = $this->PriceType->find('first', $options);
		}
		$locations = $this->PriceType->Location->find('list');
		$this->set(compact('locations'));
	}

	public function admin_delete($id = null) {
		$this->PriceType->id = $id;
		if (!$this->PriceType->exists()) {
			throw new NotFoundException(__('Invalid price type'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->PriceType->delete()) {
			$this->Session->setFlash(__('The price type has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The price type could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
