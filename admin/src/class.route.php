<?php 

class Route {

	public $route_id;
	public $route_name;
	public $start_point;
	public $end_point;
	
	/// What is the distance of this route in kilometers
	public $distance;
	
	///How long does this route take in minutes
	public $duration;

	function __construct($start_point, $end_point, $route_id, $route_name, $distance, $duration){
		$this->start_point = $start_point;
		$this->end_point = $end_point;
		$this->route_id = $route_id;
		$this->route_name = $route_name;
		$this->distance = $distance;
		$this->duration = $duration;
	}

}


?>