<?php 
	require_once('./src/class.db.php');
	require_once('./src/functions.php');
	// Initialize a db instance
	$db = new DB();
	// Fetch the routes
	$routes = $db->getAllRoutes();
	
	/*
	* Check if this is an edit
	*/
	if(isset($_GET['action']) && isset($_GET['id']) ) {
		$registration = $_GET['id'];
		//Get the bus with this registration
		$db->getBusDetail($registration);
	}
	if(isset($_POST['btn_manage_bus'])){
		
		$registration = ucwords($_POST['txt_registration']);
		$color = $_POST['sel_color'];
		$model = $_POST['txt_model'];
		
		$coach = $_POST['sel_coach'];
		$premiumSeats = $_POST['txt_seats_vip'];
		$normalSeats = $_POST['txt_seats_normal'];
		$totalSeats = $premiumSeats + $normalSeats;
//		$noOfSeats = $_POST['txt_no_of_seats'];
		$result = $db->addBus($registration,$color,$model,$coach,$totalSeats,$normalSeats, $premiumSeats);
		$successString = "The bus was added successfully";
		manageErrors($result, $successString, "bus");
		
	}
?>

<h2>Add Bus</h2>

<form method="POST">
				<?php if(isset($_GET['action']) && isset($_GET['id']) ) {
					$action = $_GET['action'];
					$registration = $_GET['id'];
					echo "<input type=\"hidden\" name=\"hid_registration\" value=\"$registration\">";
				} ?>

				<label for="txt_registration">Registration</label>
					<input type="text" name="txt_registration" label="Enter Registration" id="txt_registration" value="<?php if(isset($registration)) {echo $registration;} ?>" required>


				<div class="grid-x grid-padding-x">
					<div class="large-4 cell"><label>VIP/Premium Seats</label><input name="txt_seats_vip" id="txt_seats_vip"
                                                                                     type="number" min="0" max="50"
                                                                                     value="5" required onchange="add()"></div>
					<div class="large-4 cell"><label>Regular Seats</label><input name="txt_seats_normal" id="txt_seats_normal"
                                                                                 type="number" value="45" min="0"
                                                                                 max="50" required onchange="add()"></div>
						<div class="large-4 cell">
						<label for="txt_no_of_seats">No of Seats</label>
						<input type="number" min="0" max="50" disabled name="txt_no_of_seats" label="Enter Registration"
                               id="txt_no_of_seats"  required>	</div>
				</div>

				
				
				<label for="sel_color">Color</label>
					<select name="sel_color" label="Color" id="sel_color">
							<option val="Red">Red</option>
							<option val="Black">Black</option>
							<option val="Orange">Orange</option>
							<option val="Green">Green</option>
							<option val="Blue">Blue</option>
					</select>
				
				<label for="txt_model">Model</label>
					<input type="text" name="txt_model" label="Model" id="txt_model" value="<?php if(isset($model)){echo $model;} ?>" required>
				
				<!-- <label for="sel_route">Route</label> -->
					<!-- <select name="sel_route" label="Route" id="sel_route"> -->
						<!-- Fetch the routes and display in ascending order			 -->
						<?php
						// foreach($routes as $r){
						// 	echo "<option value=\"{$r->route_name}\">";
						// 	echo $r->route_name;
						// 	echo "</option>";
						// }
						?>
					<!-- </select> -->
				
				<label for="sel_coach">Coach</label>
					<select name="sel_coach" id="sel_coach">
						<option val="AC">AC</option>
						<option val="NON-AC">NON-AC</option>
					</select>

				<input type="submit" name="btn_manage_bus" val="SAVE" class="button">			
			</form>
<script type="application/javascript">
    function add() {
        var vipSeats = document.getElementById("txt_seats_vip").value;
        var normalSeats = document.getElementById("txt_seats_normal").value;
        var totalSeats =parseInt(vipSeats) + parseInt(normalSeats); //addition of two values
        document.getElementById("txt_no_of_seats").value = totalSeats;
    }

</script>