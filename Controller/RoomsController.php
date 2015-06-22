<?php
App::uses('AppController', 'Controller');
class RoomsController extends AppController {
	public $layout = 'BootstrapCake.bootstrap';

	public $components = array('Paginator', 'Session');

	public function get() {
		$conditions = array();

		// query string params
		$start = $this->request->query('start');
		$end   = $this->request->query('end');

		if ($start && $end) {
			$conditions['start >='] = $start;
			$conditions['end <']    = $end;
		} else {
			$conditions['start >='] = date('Y-m-01', strtotime("-1 month"));
			$conditions['end <']    = date('Y-m-t', strtotime("+5 month"));
		}

		$res = $this->Room->find('all', compact('conditions'));

		return new CakeResponse(array('body'=>json_encode($res)));
	}


	public function admin_index() {
		$this->Room->recursive = 0;
		$this->set('rooms', $this->Paginator->paginate());
	}

	public function admin_reorder() {
		if ($this->request->is('post')) {
			$this->Room->saveMany($this->request->data);
			exit();
		}
		$this->set('rooms', $this->Room->find('all'));
	}

	public function admin_view($id = null) {
		if (!$this->Room->exists($id)) {
			throw new NotFoundException(__('Invalid room'));
		}
		$options = array('conditions' => array('Room.' . $this->Room->primaryKey => $id));
		$this->set('room', $this->Room->find('first', $options));
	}

	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Room->create();
			if ($this->Room->save($this->request->data)) {
				$this->Session->setFlash(__('The room has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The room could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$locations = $this->Room->Location->find('list');
		$this->set(compact('locations'));
	}

	public function admin_edit($id = null) {
		if (!$this->Room->exists($id)) {
			throw new NotFoundException(__('Invalid room'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Room->save($this->request->data)) {
				$this->Session->setFlash(__('The room has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The room could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Room.' . $this->Room->primaryKey => $id));
			$this->request->data = $this->Room->find('first', $options);
		}
		$locations = $this->Room->Location->find('list');
		$this->set(compact('locations'));
	}

	public function admin_delete($id = null) {
		$this->Room->id = $id;
		if (!$this->Room->exists()) {
			throw new NotFoundException(__('Invalid room'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Room->delete()) {
			$this->Session->setFlash(__('The room has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The room could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
