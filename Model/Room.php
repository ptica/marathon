<?php
App::uses('AppModel', 'Model');

class Room extends AppModel {
	public $displayField = 'name';

	public $dateFields  = array('start', 'end');

	public $order = array('Room.ord'=>'asc');

	public $virtualFields = array(
		'start' => "DATE_FORMAT(`Room`.`start`, '%e.%c.%Y')",
		'end' => "DATE_FORMAT(`Room`.`end`, '%e.%c.%Y')",
	);

	public $actsAs = array('Containable');

	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'location_id' => array(
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
		'amount' => array(
			'numeric' => array(
				'rule' => array('numeric'),
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
		'Location' => array(
			'className' => 'Location',
			'foreignKey' => 'location_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasMany = array(
		'Booking' => array(
			'className' => 'Booking',
			'foreignKey' => 'room_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Price' => array(
			'className' => 'Price',
			'foreignKey' => 'room_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	private $rooms = null;
	public function get_rooms_by_id() {
		if (!$this->rooms) {
			$this->rooms = $this->find('all');
			foreach ($this->rooms as &$item) {
				//$item['Price'] = Hash::combine($item['Price'], '{n}.price_type_id', '{n}.price');
				// as of now just one price_type
				$item['Price'] = $item['Price'][0]['price'];
			}
			$this->rooms = Hash::combine($this->rooms, '{n}.Room.id', '{n}');
		}
		return $this->rooms;
	}

}
