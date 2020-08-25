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
<?php
    require ('pages/inc.feedback.php');
?>

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
	    $modalId = 1;
		$url =  "index.php?action=delete&view=bus&reg={$bus->registration}";
        displayDeleteModal($modalId, $url);
		echo "<tr>";
			echo "<td>{$bus->registration}</td>";
			echo "<td>{$bus->coach}</td>";
			echo "<td>{$bus->model}</td>";
			echo "<td>{$bus->no_of_seats}</td>";
			echo "<td><a href=\"index.php?action=edit&view=bus&id={$bus->registration}\"><i class=\"fas fa-edit\"></i></a> ";
		    echo "<a id='deleteRes' data-open='modal_$modalId'><i class=\"fas fa-trash\"></i></a></td>";
		    echo "</tr>";
		    echo "</div>";
		    $modalId++;
	}

?>
</table>
