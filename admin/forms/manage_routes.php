<?php
require_once('./src/class.db.php');
require_once('./src/functions.php');

if(isset($_POST['btn_manage_route'])){
	$start_point = $_POST['txt_start_point'];
	$end_point = $_POST['txt_end_point'];
	$route_name = $start_point.'-'.$end_point;
	$db = new DB();
	$result = $db->addRoute($route_name,$start_point,$end_point);
	if($result){
	    header("Location:index.php?action=view&view=route&status=1&response=The route was added successfully");
    }
	
}

?>
<h2>Add Route</h2>
<form method="POST">
	<label for="txt_start_point">Start</label>
		<input type="text" name="txt_start_point" id="txt_start_point" required>

	<label for="txt_end_point">Destination</label>
		<input type="text" name="txt_end_point" id="txt_end_point" required>	
	
	<input type="submit" class="button" name="btn_manage_route">
</form>