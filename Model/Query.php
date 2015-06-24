<?php
App::uses('AppModel', 'Model');

class Query extends AppModel {
	public $displayField = 'query';

	public $order = array('Query.ord'=>'asc');

}
