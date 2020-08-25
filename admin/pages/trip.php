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
		$modalId = 1;
		$url =  "index.php?action=delete&view=journey&journeyId={$trip->journeyId}";
		displayDeleteModal($modalId, $url);
		echo "<tr>";
			echo "<td>{$trip->departureDate}</td>";
			echo "<td>{$trip->departureTime}</td>";
			echo "<td>{$trip->vehicleReg}</td>";
			echo "<td>{$trip->route->route_name}</td>";
			echo "<td>{$trip->driverName}</td>";
			echo "<td>{$trip->conductorName}</td>";
			echo "<td>Edit <a href='index.php?action=detailed&view=trip&journeyId={$trip->journeyId}'>View</a> <a data-open='modal_$modalId' >Delete<a></a></td>";
		echo "</tr>";
	}

	?>
	</tbody>
</table>
