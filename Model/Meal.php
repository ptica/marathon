<?php
App::uses('AppModel', 'Model');

class Meal extends AppModel {
	public $displayField = 'name';

	public $order = array('Meal.ord'=>'asc');

}
