<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class BookingsController extends AppController {
	public $layout = 'BootstrapCake.bootstrap';

	public $components = array('Paginator', 'Session');

	public $paginate = array(
		'limit' => 75,
	);

	// declare public actions
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('add', 'edit');
	}

	public function add() {
		if ($this->request->is('post')) {
			$room_id = @$this->request->data['Booking']['room_id'];
			$beds = @$this->request->data['Booking']['beds'];
			// create a security token
			$this->request->data['Booking']['token'] = uniqid();
			$this->Booking->create();
			if ($this->Booking->save($this->request->data)) {
				$this->email_add_notice();
				// decrement amount_available
				if ($room_id) {
					$this->Booking->Room->id = $room_id;
					$this->Booking->Room->updateAll(
						array('Room.amount_left' => 'Room.amount_left - ' . $beds),
						array('Room.id' => $room_id)
					);
				}
				$this->Session->setFlash(__('The booking has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect('/thank-you');
			} else {
				$this->Session->setFlash(__('The booking could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
	}

	public function edit($token = null) {
		$conditions = array('Booking.token' => $token);
		$booking = $this->Booking->find('first', compact('conditions'));
		if (!$booking) {
			throw new NotFoundException(__('Invalid booking'));
		}
		$id = $booking['Booking']['id'];
		if ($this->request->is(array('post', 'put'))) {
			$allowed_fields = array(
				'name' => 1,
				'institution' => 1,
				'country' => 1,
				'address' => 1,
				'email' => 1,
				'fellow_email' => 1,
			);
			$sanitized_data = array();
			$sanitized_data['Booking'] = array_intersect_key($this->request->data['Booking'], $allowed_fields);
			$sanitized_data['Booking']['id'] = $id;
			if ($this->Booking->save($sanitized_data)) {
				$this->Session->setFlash(__('The registration has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect('/edit/'.$token);
			} else {
				$this->Session->setFlash(__('The registration could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Booking.' . $this->Booking->primaryKey => $id));
			$this->request->data = $this->Booking->find('first', $options);
		}
		$rooms = $this->Booking->Room->find('list');
		$priceTypes = $this->Booking->PriceType->find('list');
		$upsells = $this->Booking->Upsell->find('list');
		$this->set(compact('rooms', 'priceTypes', 'upsells'));
	}

	public function admin_index() {
		$this->Booking->recursive = 0;
		$this->Paginator->settings = $this->paginate;
		$this->set('bookings', $this->Paginator->paginate());
		//$this->set('bookings', $this->Booking->find('all'));
		$this->set('locations', $this->Booking->Room->Location->find('list'));
	}

	public function admin_view($id = null) {
		if (!$this->Booking->exists($id)) {
			throw new NotFoundException(__('Invalid booking'));
		}
		$options = array('conditions' => array('Booking.' . $this->Booking->primaryKey => $id));
		$this->set('booking', $this->Booking->find('first', $options));
	}

	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Booking->create();
			if ($this->Booking->save($this->request->data)) {
				$this->Session->setFlash(__('The booking has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The booking could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		}
		$rooms = $this->Booking->Room->find('list');
		$priceTypes = $this->Booking->PriceType->find('list');
		$upsells = $this->Booking->Upsell->find('list');
		$meals = $this->Booking->Meal->find('list');
		$queries = $this->Booking->Query->find('list');
		$this->set(compact('rooms', 'priceTypes', 'upsells', 'meals', 'queries'));
	}

	public function admin_edit($id = null) {
		if (!$this->Booking->exists($id)) {
			throw new NotFoundException(__('Invalid booking'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Booking->save($this->request->data)) {
				$this->Session->setFlash(__('The booking has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The booking could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Booking.' . $this->Booking->primaryKey => $id));
			$this->request->data = $this->Booking->find('first', $options);
			if (!$this->request->data['Booking']['room_id']) {
				$this->request->data['Booking']['beds'] = 0;
			}
		}
		$rooms = $this->Booking->Room->find('list');
		$priceTypes = $this->Booking->PriceType->find('list');
		$upsells = $this->Booking->Upsell->find('list');
		$meals = $this->Booking->Meal->find('list');
		$queries = $this->Booking->Query->find('list');
		$this->set(compact('rooms', 'priceTypes', 'upsells', 'meals', 'queries'));
	}

	public function admin_delete($id = null) {
		$this->Booking->id = $id;
		if (!$this->Booking->exists()) {
			throw new NotFoundException(__('Invalid booking'));
		}
		$booking = $this->Booking->findById($id);
		$room_id = $booking['Booking']['room_id'];
		$beds    = $booking['Booking']['beds'];
		$this->request->onlyAllow('post', 'delete');
		if ($this->Booking->delete()) {
			// credit room beds
			$this->Booking->Room->id = $room_id;
			$this->Booking->Room->updateAll(
				array('Room.amount_left' => 'Room.amount_left + ' . $beds),
				array('Room.id' => $room_id)
			);
			$this->Session->setFlash(__('The booking has been deleted.'), 'default', array('class' => 'alert alert-success'));
		} else {
			$this->Session->setFlash(__('The booking could not be deleted. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	private function email_add_notice() {
		$content = array();
		$content[] = 'Thank you for your registration!';
		$content[] = '';
		$content[] = 'You may review your registration details at:';
		$content[] = Router::url('/edit/' . $this->Booking->field('token'), true);
		$owner_mail = $this->Booking->field('email');
		$to = array($owner_mail);

		$Email = new CakeEmail('default');
		$Email->to($to);
		$Email->send($content);
	}
}
