<?php
App::uses('AppController', 'Controller');
class RoomsController extends AppController {
	public $layout = 'BootstrapCake.bootstrap';

	public $components = array('Paginator', 'Session');

	public $uses = array('Room', 'Upsell', 'Location', 'Meal', 'Query');

	// declare public actions
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('get', 'check');
	}

	public function get() {
		$conditions = array();

		// query string params
		$start = $this->request->query('start');
		$end   = $this->request->query('end');

		if ($start && $end) {
			$conditions['start >='] = $start;
			$conditions['end <']    = $end;
		} else {
			//$conditions['start >='] = date('Y-m-01', strtotime("-1 month"));
			//$conditions['end <']    = date('Y-m-t', strtotime("+5 month"));
		}

		// respect Location.deadline
		$conditions['Location.deadline >'] = date('Y-m-d H:i:s');

		$conditions['amount_left >'] = 0;

		$this->Room->contain(array(
			'Location',
			'Price'
		));

		$rooms = $this->Room->find('all', compact('conditions'));

		// list prices by price_type
		foreach ($rooms as &$item) {
			//$item['Price'] = Hash::combine($item['Price'], '{n}.price_type_id', '{n}.price');
			$item['Price'] = $item['Price'][0]['price'];
		}

		// get upsells keyed by locations
		$this->Location->bindModel(
			array('hasMany' => array(
				'Upsell' => array('order'=>'ord asc')
			))
		);
		$upsells = $this->Location->find('all');
		$upsells = Hash::combine($upsells, '{n}.Location.id', '{n}.Upsell');

		$meals = $this->Meal->find('all');
		$meals = Hash::combine($meals, '{n}.Meal.id', '{n}.Meal');
		$queries = $this->Query->find('all');
		$queries = Hash::combine($queries, '{n}.Query.id', '{n}.Query');

		$res = array(
			'rooms' => $rooms,
			'upsells' => $upsells,
			'meals' => $meals,
			'queries' => $queries
		);

		//debug($res);

		return new CakeResponse(array('body'=>json_encode($res)));
	}

	public function check($room_id=null, $beds=null, $start=null, $end=null) {
		$room_id = (int) $room_id;
		$beds = (int) $beds;
		$conditions = array(
			'Room.id' => $room_id,
			'Room.beds >=' => $beds,
			'Room.start <=' => $start,
			'Room.end >=' => $end,
			'Room.amount_left >' => 0
		);
		// do not localize dates now so we can do comparison !!!!
		// TODO rethink the dates virtualFields localization after all
		$this->Room->virtualFields['start'] = 'Room.start';
		$this->Room->virtualFields['end']   = 'Room.end';
		$room = $this->Room->find('first', compact(array('conditions')));

		if ($room) {
			return new CakeResponse(array('body'=>'OK'));
		} else {
			return new CakeResponse(array('body'=>'NOK'));
		}
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
