<?php 

class Bus {
	
	public $registration;
	public $color;
	public $model;
	public $coach;
	public $no_of_seats;

	function __construct($registration, $color, $model, $coach, $seats){
		$this->registration = $registration;
		$this->color = $color;
		$this->model = $model;
		$this->coach = $coach;
		$this->no_of_seats = $seats;
	}
	
}

?>