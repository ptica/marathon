<?php
App::uses('AppModel', 'Model');

class Upsell extends AppModel {
	public $displayField = 'name';

	public $order = array('Upsell.ord'=>'asc');

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
	
	private $upsells = null;
	public function get_upsells_by_location() {
		if (!$this->upsells) {
			$this->Location->bindModel(
				array('hasMany' => array(
					'Upsell' => array('order'=>'ord asc')
				))
			);
			$this->upsells = $this->Location->find('all');
			$this->upsells = Hash::combine($this->upsells, '{n}.Location.id', '{n}.Upsell');
		}
		return $this->upsells;
	}
}
