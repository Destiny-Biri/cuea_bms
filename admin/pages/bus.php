<?php 
	require_once('./src/class.db.php');
	$db = new DB();
	$buses = $db->getAllBuses();
?>
<div class="grid-x grid-padding-x">
	<div class="large-9 cell"><h2>Manage Vehicles</h2></div>
	<div class="large-3 cell"><a class="button" href="index.php?action=add&view=bus"><i class="fas fa-plus"></i> Add A Bus</a></div>
</div>


<p class="lead">This page allows you to manage the buses that you have in your fleet.</p>
<table>
<thead>
	<tr>
		<td>Registration</td>
		<td>Coach</td>
		<td>Model</td>
		<td>No Of Seats</td>

		<td>Action</td>
	</tr>
</thead>
<?php 
	foreach($buses as $bus){
		echo "<tr>";
			echo "<td>{$bus->registration}</td>";
			echo "<td>{$bus->coach}</td>";
			echo "<td>{$bus->model}</td>";
			echo "<td>{$bus->no_of_seats}</td>";
			echo "<td><a href=\"index.php?action=edit&view=bus&id={$bus->registration}\"><i class=\"fas fa-edit\"></i></a> ";
			echo "<a data-open=\"modal_{$bus->registration}\"><i class=\"fas fa-trash\"></i></a>  <a href=\"index.php?action=delete&view=bus&id={$bus->registration}\"><i class=\"fas fa-map-marker-alt\"></i></a></td>";
		echo "</tr>";
		echo "<div class=\"reveal\" id=\"modal_{$bus->registration}\">";
		echo "<h1>Delete Vehicle</h1>";
		echo "<p class=\"lead\">ARe you sure you want to delete the bus {$bus->registration}</p>";
		echo "<p>You cannot undo this action.</p>";	
		echo "<button class=\"close-button\" data-close aria-label=\"Close modal\" type=\"button\">";
    echo "<span aria-hidden=\"true\">&times;</span>";
  	echo "</button>";
		echo "</div>";
	}

?>
</table>
