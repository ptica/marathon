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
			$token = uniqid();
			$this->request->data['Booking']['token'] = $token;
			$this->Booking->create();
			if ($this->Booking->save($this->request->data)) {
				$booking_id = $this->Booking->id;
				// decrement amount_available
				if ($room_id) {
					$this->Booking->Room->id = $room_id;
					$this->Booking->Room->updateAll(
						array('Room.amount_left' => 'Room.amount_left - ' . $beds),
						array('Room.id' => $room_id)
					);
				}
				$this->Session->setFlash(__('The registration has been saved.'), 'default', array('class' => 'alert alert-success'));
				
				//return $this->redirect("/pay/$booking_id/$token");
				$this->email_add_notice();
				return $this->redirect('/thank-you');
			} else {
				$this->Session->setFlash(__('The registration could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
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
			$sanitized_data['Query'] = $this->request->data['Query'];
			
			if ($this->Booking->save($sanitized_data)) {
				$this->Session->setFlash(__('The registration has been saved.'), 'default', array('class' => 'alert alert-success'));
				return $this->redirect('/edit/'.$token);
			} else {
				$this->Session->setFlash(__('The registration could not be saved. Please, try again.'), 'default', array('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Booking.' . $this->Booking->primaryKey => $id));
			$this->request->data = $this->Booking->find('first', $options);
			if (!$this->request->data['Booking']['room_id']) {
				$this->request->data['Booking']['beds'] = 0;
			}
		}
		$this->request->data = $booking;
		$priceTypes          = $this->Booking->PriceType->find('list');
		$upsells             = $this->Booking->Upsell->find('list');
		$meals               = $this->Booking->Meal->find('list');
		$queries             = $this->Booking->Query->find('list');
		$rooms               = $this->Booking->Room->find('list');
		$locations           = $this->Booking->Room->Location->find('list');
		$location_desc       = $this->Booking->Room->Location->find('list', array('fields'=>array('id', 'desc')));
		$this->set(compact('rooms', 'priceTypes', 'upsells', 'meals', 'queries', 'locations', 'location_desc'));
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
	
	public function mail_all() {
		$conditions = array(
			'Booking.web_price >' => 0
		);
		$bookings = $this->Booking->find('all', compact('conditions'));
		
		foreach ($bookings as $booking) {
			echo("sending email for " . $booking['Booking']['email']. "<br>");
			$this->Booking->clear();
			$this->Booking->save(array(
				'id' =>  $booking['Booking']['id'],
				'paylink_sent' => date('Y-m-d H:i:s')
			));
			//$this->send_link_to_payment($booking['Booking']['id']);
		}
	}
	
	public function mail_one($booking_id) {
		$conditions = array(
			'Booking.id' => $booking_id
		);
		$booking = $this->Booking->find('first', compact('conditions'));
		
		echo("sending email for " . $booking['Booking']['email']. "<br>");
		$this->Booking->clear();
		$this->Booking->save(array(
			'id' =>  $booking['Booking']['id'],
			'paylink_sent' => date('Y-m-d H:i:s')
		));
		//$this->send_link_to_payment($booking['Booking']['id']);
	}
	
	public function price_all() {
		$bookings = $this->Booking->find('all');
		
		// TODO slice and dice it into a $this->Booking->get_price($booking);
		
		$this->loadModel('Room');
		$this->loadModel('Location');
		$this->loadModel('Meal');
		
		$rooms = $this->Room->find('all');
		foreach ($rooms as &$item) {
			//$item['Price'] = Hash::combine($item['Price'], '{n}.price_type_id', '{n}.price');
			$item['Price'] = $item['Price'][0]['price'];
		}
		$rooms = Hash::combine($rooms, '{n}.Room.id', '{n}');

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
		
		foreach ($bookings as $booking) {
			// normalize beds count
			if (!$booking['Booking']['room_id']) $booking['Booking']['beds'] = 0;
			
			// price_room
			$start  = explode(' ', $booking['Booking']['start']);
			$end    = explode(' ', $booking['Booking']['end']);
			$start  = strtotime($start[0]);
			$end    = strtotime($end[0]);
			$nights = $end - $start;
			$nights = floor($nights/(60*60*24));
			$room_id = $booking['Booking']['room_id'];
			
			$price_room = $booking['Booking']['beds'] * $nights * @$rooms[$room_id]['Price'];
			
			// price_meals
			$price_meals = 0;
			if (!empty($booking['Meals'])) foreach ($booking['Meals'] as $meal) {
				$price_meals += $meal['price'];
			}
			
			// price addons
			$price_addons = 0;
			if (!empty($booking['Upsell'])) foreach ($booking['Upsell'] as $upsell) {
				$price_addons += $booking['Booking']['beds'] * $nights * $upsell['price'];
			}
			
			$price =  $price_room + $price_meals + $price_addons;
			
			$this->Booking->clear();
			$this->Booking->save(array(
				'id' =>  $booking['Booking']['id'],
				'web_price' => $price
			));
		}
	}
	
	/**
	 * payment email
	 */
	private function send_link_to_payment($booking_id) {
		$booking_id = (int) $booking_id;
		$cnd = array( 'Booking.id' => $booking_id );

		$booking = $this->Booking->find('first', array('conditions'=>$cnd));
		if (!$booking) {
			echo 'Payment not found.';
			exit();
		}

		$this->set_request_scheme();
		$token = $booking['Booking']['token'];
		$subject = 'MTM 2015 Registration Payment';
		$to = $booking['Booking']['email'];
		$to = array($to);
		
		$content = array();
		$content[] = 'Hello!';
		$content[] = '';
		$content[] = 'Please review your registration details and proceed to payment at ';
		$content[] = Router::url("/pay/$booking_id/$token", $absolute=true);
		$content[] = '';
		$content[] = 'Take care, the MTM 2015 team.';

		$Email = new CakeEmail('default');
		$Email->to($to);
		$Email->send($content);
	}
}
