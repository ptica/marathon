<?php
App::uses('AppController', 'Controller');
class UpsellsController extends AppController {
	public $layout = 'BootstrapCake.bootstrap';

	public $components = array('Paginator', 'Session');


	public function admin_index() {
		$this->Upsell->recursive = 0;
		$this->set('upsells', $this->Paginator->paginate());
	}

	public function admin_reorder() {
		if ($this->request->is('post')) {
			$this->Upsell->saveMany($this->request->data);
			exit();
		}
		$this->set('upsells', $this->Upsell->find('all'));
	}

	public function admin_view($id = null) {
		if (!$this->Upsell->exists($id)) {
			throw new NotFoundException(__('Invalid upsell'));
		}
		$options = array('conditions' => array('Upsell.' . $this->Upsell->primaryKey => $id));
		$this->set('upsell', $this->Upsell->find('first', $options));
	}

	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Upsell->create();
			if ($this->Upsell->save($this->request->data)) {
				$this->Session->setFlash(__('The upsell has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The upsell could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$locations = $this->Upsell->Location->find('list');
		$this->set(compact('locations'));
	}

	public function admin_edit($id = null) {
		if (!$this->Upsell->exists($id)) {
			throw new NotFoundException(__('Invalid upsell'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Upsell->save($this->request->data)) {
				$this->Session->setFlash(__('The upsell has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The upsell could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Upsell.' . $this->Upsell->primaryKey => $id));
			$this->request->data = $this->Upsell->find('first', $options);
		}
		$locations = $this->Upsell->Location->find('list');
		$this->set(compact('locations'));
	}

	public function admin_delete($id = null) {
		$this->Upsell->id = $id;
		if (!$this->Upsell->exists()) {
			throw new NotFoundException(__('Invalid upsell'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Upsell->delete()) {
			$this->Session->setFlash(__('The upsell has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The upsell could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
