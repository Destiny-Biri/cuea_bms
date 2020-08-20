<?php

require_once('class.bus.php');
require_once('class.route.php');

class Trip{

	public $journeyId;
	public $departureDate;
	public $departureTime;
	public $vehicleReg;
	public $routeId;
	public $driverId;
	public $conductorId;
	public $driverName;
	public $conductorName;
	
	public $vehicle;
	public $route;

	function __construct(String $journeyId,$departureDate,$departureTime,String $vehicleReg, int $routeId, int $driverId, int $conductorId, String $color, $model, $coach, $seats, $start_point, $end_point,$routeName,$distance,$duration) {
		$this->journeyId = $journeyId;
		$this->departureDate = $departureDate;
		$this->departureTime = $departureTime;
		$this->vehicleReg = $vehicleReg;
		$this->routeId = $routeId;
		$this->driverId = $driverId;
		$this->conductorId = $conductorId;

		$this->vehicle = new Bus($vehicleReg,$color,$model,$coach,$seats);
		$this->route = new Route($start_point,$end_point,$routeId,$routeName,$distance, $duration);
	}


}