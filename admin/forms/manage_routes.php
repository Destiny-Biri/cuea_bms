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
	$start_point = ucfirst(strtolower(trim($_POST['txt_start_point'])));
	$end_point = ucfirst(strtolower(trim($_POST['txt_end_point'])));
	$route_name = $start_point.'-'.$end_point;
	$db = new DB();
	if(isset($_POST['hid_routeId'])) {
	    $result = $db->updateRoute($routeId, $start_point, $end_point, $route_name);
	    $successString = "The route was updated successfully/";
	    manageErrors($result, $successString, "route");
	}else{
		$result = $db->addRoute($route_name,$start_point,$end_point);
		$successString = "Route was added successfully";
		manageErrors($result, $successString, "route");
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

    <div id="validRoute">

    </div>
	<label for="txt_start_point">Start</label>
		<input type="text" name="txt_start_point" id="txt_start_point" value="<?php echo $start_point?>" required>

	<label for="txt_end_point">Destination</label>
		<input type="text" name="txt_end_point" id="txt_end_point" onchange="checkIfRouteExists()" value="<?php echo $end_point ?>" required>
	
	<input type="submit" class="button" name="btn_manage_route">
</form>

<script>

        function checkIfRouteExists(){
            // Get the value input
            var startPoint = document.getElementById("txt_start_point").value;
            var stopPoint = document.getElementById("txt_end_point").value;
            // divValidRoute.style.display = "block";
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    document.getElementById("validRoute").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "validate.php?validate=route&start=" + startPoint+"&stop="+stopPoint, true);
            xmlhttp.send();
        }

</script>