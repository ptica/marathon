<?php
App::uses('AppModel', 'Model');

class Meal extends AppModel {
	public $displayField = 'name';

	public $order = array('Meal.ord'=>'asc');
	
	private $meals = null;
	public function get_meals_by_id() {
		if (!$this->meals) {
			$this->meals = $this->find('all');
			$this->meals = Hash::combine($this->meals, '{n}.Meal.id', '{n}.Meal');
		}
		return $this->meals;
	}

}
