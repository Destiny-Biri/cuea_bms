<?php 
	require_once('./src/class.db.php');
	$db = new DB();
	$trips = $db->getAllTrips();
?>
<div class="grid-x grid-padding-x">
<div class="large-8 cell">
	<h2>Manage Trips</h2>
</div>
<div class="large-4 cell">
	<a class="button" href="index.php?view=trip&action=add"><i class="fas fa-plus"></i> Schedule A Trip</a>
</div>
</div>
<p>
This page shall assist you in scheduling trips. Ensure that you dont overwork the crew members by assigning them multiple journeys without breaks.
</p>
<?php
require ('pages/inc.feedback.php');
?>
<table>
	<thead>
		<td>Departure Date</td>
		<td>Departure Time</td>
		<td>Vehicle Reg</td>
		<td>Route</td>
		<td>Driver</td>
		<td>Conductor</td>
		<td>Action</td>
	</thead>
	<tbody>
	<?php
	foreach($trips as $trip){
		echo "<tr>";
			echo "<td>{$trip->departureDate}</td>";
			echo "<td>{$trip->departureTime}</td>";
			echo "<td>{$trip->vehicleReg}</td>";
			echo "<td>{$trip->route->route_name}</td>";
			echo "<td>{$trip->driverId}</td>";
			echo "<td>{$trip->conductorId}</td>";
			echo "<td>Edit View <a href='index.php?action=delete&view=journey&journeyId={$trip->journeyId}'>Delete<a></a></td>";
		echo "</tr>";
	}

	?>
	</tbody>
</table>
