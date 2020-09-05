<?php
session_start();
require_once('admin/src/class.db.php');
/// If the username is not set redirect the user to the homepage
if(!isset($_SESSION['username'])) {	
	header('Location: login.php');
}
//Set the max and min dates for booking
//Today
$today=date('Y-m-d');
// max booking date is 31 days or apprx one month
$minDate=$today;
$maxDate=Date('Y-m-d', strtotime('+31 days'));

// Get the destinations
//@TODO: Limit the journeys that are shown to be valid
$db = new DB();
$startPoint = $db->fetchDistinctDestinations('start_point');
$endPointArray = $db->fetchDistinctDestinations('end_point');
?>
<?php
if((isset($_POST['btn_checkout']))&&(isset($_POST['hid_journeyId']))){

	//Get the journey id from the hidden field
	$journeyId = $_POST['hid_journeyId'];
	
	//Get the time the booking was done
	$bookingTime = Date('Y-m-d');
	
	//Get the email of the person who is booking
	$email = $_SESSION['username'];

	$amount = 0;
	
	$orderStatus = "Draft";
	//Check if the user has selected any seats
	if(isset($_POST['seat'])){
		$bookingDetail = $_POST['seat'];
		foreach($_POST['seat'] as $seatPrice){
			$pieces = explode('_',$seatPrice);
			$seatId = $pieces[0];
			$seatPrice = $pieces[1];
			//Add this seat price
			$amount += $seatPrice;
			
		}
		//Add the booking to the database
		$result = $db->makeBooking($journeyId,$email,$amount,$orderStatus,$bookingDetail);

		//Use the result
		$_SESSION['booking'] = $result;
		header('Location: checkout.php');
	}else{
		echo "No seat selected";
	}

}

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="assets/css/foundation.css">
  <link rel="stylesheet" href="assets/css/app.css">
	<link rel="stylesheet" type="text/css" href="assets/css/book.css">
	<link rel="stylesheet" href="fontawesome/css/all.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:semibold,regular,bold">
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	

</head>
<body>
	<?php include('includes/inc.top_nav.php'); ?>
	<div class="box">
		<form method="POST">
		
		<label class="step" for="txt_dateOfTravel">1. Date Of Travel
			<input type="date" name="txt_dateOfTravel" onchange="updateTravelDate(this.value)" id="txt_dateOfTravel" value="<?php echo $minDate ?>" min="<?php echo$minDate ?>" max="<?php echo$maxDate ?>">
		</label>
		<label class="step" for="sel_source_station">2. Where will you start your journey
		<select name="sel_source" id="sel_source" onchange="updateStartPoint(this.value)">
		<?php
			///Fetch all destinations
			foreach($startPoint as $sp){
				echo "<option value=\"{$sp['point']}\">";
				echo $sp['point'];
				echo "</option>";
			}			
		?>
		</select>
		</label>
		<label class="step" for="sel_destination">3. Where do you want to go ? 
		<select name="sel_destination" id="sel_destination" onchange="updateStopPoint(this.value)">
		<?php
			///Fetch all destinations
			///Fetch all destinations
			foreach($endPointArray as $ep){
				echo "<option value=\"{$ep['point']}\">";
				echo $ep['point'];
				echo "</option>";
			}	
		?>
		</select>
		</label>

		<p class="step">4. Available Trips</p>
		<p id="availableOptions"></p>
		<div id="suggested"></div>
		<div id="seatSelectionBox">
			<label class="step">5. Seat Selection</label>
			<div id="availableSeats"></div>
		</div>
		
		<input type="submit" name="btn_checkout" value="CHECKOUT">
		
	</form>

		
	</div>


	<script src="assets/js/vendor/jquery.js"></script>
  <script src="assets/js/vendor/what-input.js"></script>
	<script src="assets/js/vendor/foundation.js"></script>
<!--	<script src="assets/js/vendor/foundation.equalizer.min.js"></script>-->
	<script src="assets/js/app.js"></script>
	
</body>
</html>