<?php
App::uses('AppModel', 'Model');

class PriceType extends AppModel {
	public $displayField = 'name';

	public $order = array('PriceType.ord'=>'asc');

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	public $hasAndBelongsToMany = array(
		'Location' => array(
			'className' => 'Location',
			'joinTable' => 'locations_price_types',
			'foreignKey' => 'price_type_id',
			'associationForeignKey' => 'location_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

}
