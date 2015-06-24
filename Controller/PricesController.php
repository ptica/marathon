<?php
App::uses('AppController', 'Controller');
class PricesController extends AppController {
	public $layout = 'BootstrapCake.bootstrap';

	public $components = array('Paginator', 'Session');

	public function admin_index() {
		$this->Price->Room->bindModel(array('belongsTo'=>array('Location')));
		// TODO
		// get Rooms joined with Location
		// to virtualField works
		//$this->Price->Room->virtualFields['fullname'] = "CONCAT(`Room`.`name`, ' (', `Location`.`name`, ', ', DATE_FORMAT(`Room`.`start`, '%e.%c.'), ' - ', DATE_FORMAT(`Room`.`end`, '%e.%c.'), ')')";
		$this->Price->Room->virtualFields['fullname'] = 'Room.name';
		$this->Price->recursive = 0;
		$this->set('prices', $this->Paginator->paginate());
	}

	public function admin_view($id = null) {
		if (!$this->Price->exists($id)) {
			throw new NotFoundException(__('Invalid price'));
		}
		$options = array('conditions' => array('Price.' . $this->Price->primaryKey => $id));
		$this->set('price', $this->Price->find('first', $options));
	}

	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Price->create();
			if ($this->Price->save($this->request->data)) {
				$this->Session->setFlash(__('The price has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The price could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$rooms = $this->Price->Room->find('list');
		$priceTypes = $this->Price->PriceType->find('list');
		$this->set(compact('rooms', 'priceTypes'));
	}

	public function admin_edit($id = null) {
		if (!$this->Price->exists($id)) {
			throw new NotFoundException(__('Invalid price'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Price->save($this->request->data)) {
				$this->Session->setFlash(__('The price has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The price could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Price.' . $this->Price->primaryKey => $id));
			$this->request->data = $this->Price->find('first', $options);
		}
		$rooms = $this->Price->Room->find('list');
		$priceTypes = $this->Price->PriceType->find('list');
		$this->set(compact('rooms', 'priceTypes'));
	}

	public function admin_delete($id = null) {
		$this->Price->id = $id;
		if (!$this->Price->exists()) {
			throw new NotFoundException(__('Invalid price'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Price->delete()) {
			$this->Session->setFlash(__('The price has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The price could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
