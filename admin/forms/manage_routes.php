<?php
require_once('./src/class.db.php');
require_once('./src/functions.php');

if(isset($_GET['routeId'])){
	$routeId = $_GET['routeId'];
	$db = new DB();
	$result = $db->fetchRouteById($routeId);
	if(!(is_string($result))){
		$start_point = $result->start_point;
		$end_point = $result->end_point;
	}else{
		$start_point = "";
		$end_point = "";
    }
}else{
	$start_point = "";
	$end_point = "";
}


if(isset($_POST['btn_manage_route'])){
	$start_point = $_POST['txt_start_point'];
	$end_point = $_POST['txt_end_point'];
	$route_name = $start_point.'-'.$end_point;
	$db = new DB();
	if(isset($_POST['hid_routeId'])) {
	    $result = $db->updateRoute($routeId, $start_point, $end_point, $route_name);
	    if(is_string($result)){
	        $status = false;
	        $response = $result;
        }else{
			$status = $result;
			$response = "The route was updated successfully/";
        }
    }else{
		$result = $db->addRoute($route_name,$start_point,$end_point);
		$status = 1;
		$response = "Route was added successfully";
    }
	if($result){
	    header("Location:index.php?action=view&view=route&status=$status&response=$response");
    }
	
}

?>
<h2>
    <?php
    if(isset($_GET['routeId'])){
        $routeId = (int)$_GET['routeId'];
        echo "Edit Route";
    }else {
        echo "Add Route";
    }
    ?>
</h2>
<form method="POST">
    <?php
	if(isset($_GET['routeId'])){
		$routeId = $_GET['routeId'];
		echo "<input type='hidden' name='hid_routeId' value='$routeId'>";
	}else{
		$start_point = "";
		$destination = "";
	}


    ?>
	<label for="txt_start_point">Start</label>
		<input type="text" name="txt_start_point" id="txt_start_point" value="<?php echo $start_point?>" required>

	<label for="txt_end_point">Destination</label>
		<input type="text" name="txt_end_point" id="txt_end_point" value="<?php echo $end_point ?>" required>
	
	<input type="submit" class="button" name="btn_manage_route">
</form>