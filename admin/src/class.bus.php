<?php 

class Bus {
	
	public $registration;
	public $color;
	public $model;
	public $coach;
	public $no_of_seats;
	public $imgUrl;
	public $normal_seats;
	public $vip_seats;

	function __construct($registration, $color, String $model, String $coach, int $seats, String $imgUrl, int
	$normal_seats,
						 int $vip_seats){
		$this->registration = $registration;
		$this->color = $color;
		$this->model = $model;
		$this->coach = $coach;
		$this->no_of_seats = $seats;
		$this->imgUrl = $imgUrl;
		$this->normal_seats = $normal_seats;
		$this->vip_seats = $vip_seats;
	}
	
}