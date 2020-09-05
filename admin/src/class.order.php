<?php

//include 'class.trip.php';
class Order {

	public $booking_id;
	public $journey_id;

	public $booking_time;
	public $email;
	public $amount;
	public $route_name;
	public $journey;
	/**
	 * What is the order status
	 * It can have the values Draft,AwaitingClientPayment,AwaitingBookingConfirmation,Cancelled,Complete
	 */
	public $order_status;
	
	

	function  __construct(String $booking_id, String $journey_id, String $booking_time, String $email,
						  int $amount, String $route_name,String $order_status, String $departureDate, String
						  $departureTime, String $vehicleReg, int $routeId, int $driverId, int $conductorId, String
						  $color, String $model, String $coach,$seats,$start_point,$end_point,$distance,$duration,
						  $driverName,$conductorName,$imgurl,$normal_seats, $vip_seats ) {
		$this->booking_id = $booking_id;
		$this->journey_id = $journey_id;
		$this->booking_time = $booking_time;
		$this->email = $email;
		$this->amount = $amount;
		$this->route_name = $route_name;
		$this->order_status = $order_status;
		$this->journey = new Trip($journey_id,$departureDate,$departureTime,$vehicleReg,$routeId,$driverId,
			$conductorId,$color,$model,$coach,$seats,$start_point,$end_point,$route_name,$distance,$duration,
			$driverName,$conductorName,$imgurl,$normal_seats, $vip_seats);

	}

}