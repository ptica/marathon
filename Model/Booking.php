<?php
App::uses('AppModel', 'Model');
class Booking extends AppModel {
	public $displayField = 'email';

	public $dateFields = array('start', 'end');

	public $validate = array(
		'price_type_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'beds' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	public $belongsTo = array(
		'Room' => array(
			'className' => 'Room',
			'foreignKey' => 'room_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PriceType' => array(
			'className' => 'PriceType',
			'foreignKey' => 'price_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasAndBelongsToMany = array(
		'Upsell' => array(
			'className' => 'Upsell',
			'joinTable' => 'bookings_upsells',
			'foreignKey' => 'booking_id',
			'associationForeignKey' => 'upsell_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		),
		'Query' => array(
			'className' => 'Query',
			'joinTable' => 'bookings_queries',
			'foreignKey' => 'booking_id',
			'associationForeignKey' => 'query_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		),
		'Meal' => array(
			'className' => 'Meal',
			'joinTable' => 'bookings_meals',
			'foreignKey' => 'booking_id',
			'associationForeignKey' => 'meal_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

	public function afterFind($result, $primary = false) {
		foreach ($result as $key => &$item) {
			// normalize beds count
			if (@!$item['Booking']['room_id']) {
				$item['Booking']['beds'] = 0;
			}
			
			if (isset($item['Booking']['start']) &&
				isset($item['Booking']['end'])
			) {
				$s = explode(' ', $item['Booking']['start']);
				$s = explode('-', $s[0]);
				$e = explode(' ', $item['Booking']['end']);
				$e = explode('-', $e[0]);
				/// define indexes
				$day   = 2;
				$month = 1;
				$year  = 0;
				//
				if ($s[$year] == $e[$year] && $s[$month] == $e[$month]) {
					$item['Booking']['date_txt'] = "${s[$day]}. – ${e[$day]}. ${e[$month]}.";
				} else {
					$item['Booking']['date_txt'] = "${s[$day]}. ${s[$month]}. – ${e[$day]}. ${e[$month]}.";
				}

			}
		}
		return $result;
	}
	
	public function get_price($booking, $per_partes=false) {
		$rooms = $this->Room->get_rooms_by_id();
		//$upsells = $this->Upsell->get_upsells_by_location();
		//$meals = $this->Meals->get_meals_by_id();
		
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
		if (!empty($booking['Meal'])) foreach ($booking['Meal'] as $meal) {
			$price_meals += $meal['price'];
		}
		
		// price addons
		$price_addons = 0;
		if (!empty($booking['Upsell'])) foreach ($booking['Upsell'] as $upsell) {
			$price_addons += $booking['Booking']['beds'] * $nights * $upsell['price'];
		}
		
		$price =  $price_room + $price_meals + $price_addons;
		
		if ($per_partes) {
			return array(
				'room' => $price_room,
				'addons' => $price_addons,
				'accomodation' => $price_room + $price_addons,
				'meals' => $price_meals
			);
		}
		return $price;
	}

}
