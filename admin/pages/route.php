<?php 
	require_once('./src/class.db.php');
	$db = new DB();
	$routes = $db->getAllRoutes();
?>
<div class="grid-x grid-padding-x">
<div class="large-9 cell">
<h2>Manage Routes</h2>
</div>
<div class="large-3 cell">
<a class="button" href="index.php?action=add&view=route"><i class="fas fa-plus"></i> Add A Route</a>
</div>
</div>

<p class="lead">This page allows you to manage the routes/destinations that we provide to our customers.The routename is generated automatically from the the start point and end point.</p>
<table>
<thead>
	<tr>
		<td>Route Name</td>
		<td>Start point</td>
		<td>Destination</td>
		<td>Waypoints</td>
		<td>Distance</td>
		<td>Duration</td>
		<td></td>
		<td></td>
	</tr>
</thead>
<?php 
	foreach($routes as $route){
		echo "<tr>";
			echo "<td>{$route->route_name}</td>";
			echo "<td>{$route->start_point}</td>";
			echo "<td>{$route->end_point}</td>";
			echo "<td></td>";
			echo "<td>{$route->distance} kms</td>";
			echo "<td>{$route->duration} mins</td>";
			echo "<td>Edit</td>";
			echo "<td>Delete</td>";
		echo "</tr>";
	}

?>
</table>