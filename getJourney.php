<?php
session_start();
require_once('admin/src/class.db.php');
if(isset($_GET['dot'])) {
	$dateOfTravel = $_GET['dot'];
}
if(isset($_GET['sp']) ) {
	$startPoint = $_GET['sp'];
}
if(isset($_GET['dp'])) {
	$endPoint = $_GET['dp'];
}
$db = new DB();
$result = $db->fetchJourneyThatMatchesCriteria($startPoint,$endPoint,$dateOfTravel);
if(count($result)>0){
	$noOfTrips = count($result);
	echo "<p class='result'>We have $noOfTrips scheduled trips for your selected date. Select the bus with your preferred departure time.</p>";
	// echo "<label for=\"sel_departureTime\">What time do you want to leave";
	// echo "<select name=\"sel_departureTime\" id=\"sel_departureTime\" onChange=\"fetchAvailableSeats(this.value)\" >";
	// foreach($result as $res){
	// 	echo "<option value=\"{$res['journey_id']}\">";
	// 	echo $res['imgurl']  . $res['vehicle_reg'] . ' ' . $res['departure_time'];
	// 	echo "</option>";
	// }
	// echo "</select>";
	// echo "<label>";
	echo "<div class='grid-x grid-margin-x grid-margin-y' id='buses'>";
	foreach($result as $res){
		$journeyId = $res['journey_id'];
		echo "<div class=\"large-4 cell busPreview\">";
			echo "<div class=\"\">";
				echo "<h3>{$res['departure_time']}</h3>";
				echo "<img class='thumbnail' src='admin/{$res['imgurl']}'>";
				echo "<ul class='no-bullet bus_select'>";
					echo "<li>Bus Model : {$res['model']}</li>";
					echo "<li>Coach Type : {$res['coach']}</li>";
					echo "<li>Registration  : {$res['vehicle_reg']}</li>";
					echo "<li>Capacity  : {$res['no_of_seats']} pax</li>";
				echo "</ul>";
				echo "<input type=\"radio\" value=\"$journeyId\" name=\"rad_journeySelect\" id=\"rad_journeySelect\" onChange=\"fetchAvailableSeats($journeyId)\">";
				echo "</div>";
		echo "</div>";
	}
	echo "<div class=\"large-8 cell\" id=\"orderSummary\">";
	echo "<h3>Order Summary</h3>";
	echo "</div>";
	echo "</div>";
	
}else{
	echo "<p class='result'>Sorry. We have no scheduled trips that meet your criteria.</p>";
}
// echo "Pricing";
// echo "<div>";
// echo "<div>Normal Price : <span id='normalPrice'></span></div>";
// echo "<div>Premium Seat : <span id='normalPrice'></span></div>";
// echo "</div>";	

?>