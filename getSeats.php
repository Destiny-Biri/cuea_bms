<?php 
session_start();
require_once('admin/src/class.db.php');
if(isset($_GET['journeyId'])){
	$journeyId = $_GET['journeyId'];


	echo "<input type='hidden' name='hid_journeyId' value=\"$journeyId\" id='hid_journeyId'>  ";
	
	$db = new DB();
	$availableSeats = $db->fetchAvailableSeatsForJourney($journeyId);
	$numOfSeats = floor((count($availableSeats,COUNT_RECURSIVE)/9));	
	if($numOfSeats>0){
		$seats = count($availableSeats);
		echo "<p>There are $seats seats available.</p>";
		foreach($availableSeats as $seat){
			//We use the ternary operator to check the price of the seat using the isPremiumFlag
			$seatPrice = $seat['isPremium'] == 0 ? $seat['normal_price'] : $seat['premium_price']; 
			
			//Concat the price and seat id on the value of input
			echo "<input type=\"checkbox\" name=\"seat[]\" value=\"{$seat['seat_id']}_{$seatPrice}\" ";
			if($seat['isUsable'] == 0){
				echo " checked checked ";
			}
			echo "/><label>";
			echo "{$seat['seatName']}";
			if($seat['isPremium']){
				echo " VIP ";
			} else {
				echo " Non-VIP";
			}
			echo "</label>";
		}
		
	}
	else{
		echo "<p class='result'>Sorry. There are no seats available on the selected bus.</p>";
	}
}else{
	echo "<p>You have not selected a time.</p>";
}