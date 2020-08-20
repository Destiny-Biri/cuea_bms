<?php

class OrderDetail {
	public $booking_id;
	public $booking_detail_id;
	public $seat_id;
	public $assignedTo;
	public $journeyId;
	public $price;
	
	function __construct(int $booking_id, int $booking_detail_id, int $seat_id, String $assignedTo, int $journeyId, int $amount){
		$this->booking_id = $booking_id;
		$this->booking_detail_id = $booking_detail_id;
		$this->seat_id = $seat_id;
		$this->assignedTo = $assignedTo;
		$this->journeyId = $journeyId;
		$this->price = $amount;
	}
}