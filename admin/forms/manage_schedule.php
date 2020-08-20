<?php 
	require_once('./src/class.db.php');
	$db = new DB();
	$buses = $db->getAllBuses();
	$routes = $db->getAllRoutes();
	$drivers = $db->getCrew('Driver');
	$conductors = $db->getCrew('Conductor');
	if(isset($_POST['btn_manage_schedule'])){
		$route = $_POST['sel_route'];
		$departureDate = $_POST['txt_scheduled_date'];
		$departureTime = $_POST['txt_scheduled_time'];
		$driverId = $_POST['sel_driver'];
		$vehicleReg = $_POST['sel_vehicle'];
		$conductorId = $_POST['sel_conductor'];
		$normalPrice = $_POST['txt_normalPrice'];
		$premiumPrice = $_POST['txt_premiumPrice'];
		$endDate = $_POST['txt_enddate'];

		///Check if this is a return journey
		if(isset($_POST['chk_makeRoutine'])) {
			$result = $db->createRecurringJourney($departureDate,$departureTime,$vehicleReg,$route,$driverId,$conductorId,$normalPrice,$premiumPrice,$endDate);
		} else{
			$result = $db->addScheduledTrip($departureDate,$departureTime,$vehicleReg,$route,$driverId,$conductorId,$normalPrice,$premiumPrice);
		}

		
		if($result == true){
			//@TODO: Clear the $_POST to prevent resubmission
			// Redirect the user to the index page
			// Show a success message
			header('Location:index.php?action=view&view=trip&status=1&response=The scheduled trips were added successfully.');
		}else{
			// Display the error message returned
			header("Location:index.php?action=view&view=trip&status=1&response=$result");
		}
		

	}
?>
<p>This page will enable you to schedule journeys.</p>
<form method="POST">

	<div class="grid-x grid-padding-x">
		<div class="large-6 cell">
			<label for="sel_route">Route
				<select name="sel_route" id="sel_route">
					<?php
						foreach($routes as $route){
							echo "<option value=\"{$route->route_id}\">";
							echo strtoupper($route->route_name);
							echo "</option>";
						}
					?>
				</select>
			</label>
		</div>
						
		<div class="large-3 cell">
			<!-- Date of journey -->
			<label for="txt_scheduled_date">Departure Date
			<input type="date" id="txt_scheduled_date" name="txt_scheduled_date"  value="<?php echo date("Y-m-d") ?>" min="<?php echo date("Y-m-d") ?>"></label>
		</div>

		<div class="large-3 cell">
			<!-- Time of journey -->
		<label>Departure Time
		<input type="time" name="txt_scheduled_time" id="txt_scheduled_time" value="<?php echo date("H:i") ?>">
		</label>
		</div>
	</div>
	
	
	<div class="grid-x grid-padding-x">
		<div class="large-4 medium-4 cell">
			<!-- The route -->
			<label>Vehicle Registration
				<select name="sel_vehicle">
				<?php
					foreach($buses as $bus){
						echo "<option value=\"{$bus->registration}\">";
						echo ucwords(strtoupper($bus->registration));
						echo "</option>";
					}
				?>
				</select>
			</label>
		</div>

		<div class="large-4 medium-4 cell">
			<!-- Driver -->
			<label>Driver
			<select name="sel_driver">
			<?php
					foreach($drivers as $driver){
						echo "<option value=\"{$driver->crew_id}\">";
						echo $driver->crew_name;
						echo "</option>";
					}
				?>
			</select>
			</label>
		</div>

		<div class="large-4 medium-4 cell">
			<!-- Conductor / Turn boy -->
			<label>Conductor / Turnboy
			<select name="sel_conductor">
			<?php
					foreach($conductors as $conductor){
						echo "<option value=\"{$conductor->crew_id}\">";
						echo $conductor->crew_name;
						echo "</option>";
					}
				?>
			</select>
			</label>
		</div>

		<div class="large-6 cell">
			<label for="txt_normalPrice">Cost of normal seat
			<input type="text" name="txt_normalPrice" id="txt_normalPrice">
			</label>
		</div>

		<div class="large-6 cell">
			<label for="txt_premiumPrice">Cost of premium seat
			<input type="text" name="txt_premiumPrice" id="txt_premiumPrice">
			</label>
		</div>


		<div class="large-12 cell">
					<label for="chk_makeRoutine">Make This routine
						<input type="checkbox" name="chk_makeRoutine" id="chk_makeRoutine">
					</label>
					<label for="txt_enddate">End Date
					<input type="date" name="txt_enddate" id="txt_enddate" min="<?php echo Date('Y-m-d')?>" value="<?php echo Date('Y-m-d')?>">
					</label>
					
		</div>
		

		
	</div>



	<input class="button extended" type="submit" value="SAVE" name="btn_manage_schedule">
</form>
