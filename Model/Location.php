<?php
App::uses('AppModel', 'Model');
class Location extends AppModel {
	public $displayField = 'name';

	public $dateFields  = array('deadline');

	public $virtualFields = array(
		'deadline' => "DATE_FORMAT(`Location`.`deadline`, '%e.%c.%Y')",
	);

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
	);
}
