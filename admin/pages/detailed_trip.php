<?php
require_once('./src/class.db.php');
$db = new DB();
if(isset($_GET['journeyId'])) {
	$journeyId = (int)$_GET['journeyId'];
	$result  = $db->fetchJourneyDetails($journeyId);

//	var_dump($journey);
//	die();
}

?>
<h2>Manage Trips</h2>
<div class="grid-x">
	<div class="large-8 cell">
		<h3>Details for Journey</h3>
	</div>
	<div class="large-4 cell">
		<a href="index.php?view=trip&action=view" class="button">Back to Manage Trips</a>
	</div>
</div>

<?php

if(!is_string($result)){
	echo "<table>";
	echo "<thead>";
	echo "<tr>";
	echo "<td>Booking Id</td>";
	echo "<td>Booking Date</td>";
	echo "<td>Seat No</td>";
	echo "<td>Assigned To</td>";
	echo "<td>Status</td>";
	echo "<td>Amount Paid/Due</td>";
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
	foreach ($result as $detail) {
		echo "<tr>";
		echo "<td>{$detail['booking_id']}</td>";
		echo "<td>{$detail['booking_time']}</td>";
		echo "<td>{$detail['seat_id']}</td>";
		echo "<td>{$detail['assignedTo']}</td>";
		echo "<td>{$detail['order_status']}</td>";
        echo "<td>{$detail['amount']}</td>";
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";
}


