<?php
App::uses('AppModel', 'Model');
class Location extends AppModel {
	public $displayField = 'name';

	public $dateFields  = array('deadline');

	public $virtualFields = array(
		'deadline' => "DATE_FORMAT(`Location`.`deadline`, '%e.%c.%Y %H:%i')",
	);

	/**
	 * various date to sql format
	 */
	public function date_to_sql($from) {
		// \xC2\xA0 is &nbsp; entity
		$from = preg_replace("/(\s|\xc2\xa0)+/", '', $from);
		// missing dot
		if (preg_match('/^\d{1,2}\.\d{1,2}$/', $from))
			$from = $from . '.';
		// missing year
		if (preg_match('/^\d{1,2}\.\d{1,2}.$/', $from))
			$from = $from . date('Y');
		($date = date_create_from_format('j#n#y H:i', $from))	   # d-m-y
		|| ($date = date_create_from_format('j#n#Y H:i', $from))	# d-m-yyyy
		|| ($date = date_create_from_format('j#n#Y H:i', date('j.n.Y', strtotime($from))));
		return date_format($date, 'Y-m-d H:i:s');
	}

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
