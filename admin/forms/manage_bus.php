<?php 
	require_once('./src/class.db.php');
	require_once('./src/functions.php');
	// Initialize a db instance
	$db = new DB();
	// Fetch the routes
	$routes = $db->getAllRoutes();
$imgUrl = "";
$color = "";
$coach = "";
$vip_seats = 0;
$normalSeats = 0;
$noOfSeats = $vip_seats + $normalSeats;
$model = "";
	/*
	* Check if this is an edit
	*/
	if(isset($_GET['action']) && isset($_GET['id']) ) {
		$registration = $_GET['id'];
		//Get the bus with this registration
		$result = $db->getBusDetail($registration);
		if(is_array($result)){
		    //@TODO: Display an error
            var_dump($result[0]);

        }else{
		    $registration = $result->registration;
		    $imgUrl = $result->imgUrl;
		    $normalSeats = $result->normal_seats;
		    $vip_seats = $result->vip_seats;
		    $coach = $result->coach;
		    $model = $result->model;
		    $color = $result->color;
		    $noOfSeats = $result->no_of_seats;

        }
	}
	if(isset($_POST['btn_manage_bus'])){
		$target_dir = "images/uploads/buses/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$registration = ucwords($_POST['txt_registration']);
		$color = $_POST['sel_color'];
		$model = $_POST['sel_selmodel'];
		$coach = $_POST['sel_coach'];
		$premiumSeats = $_POST['txt_seats_vip'];
		$normalSeats = $_POST['txt_seats_normal'];
		$totalSeats = $premiumSeats + $normalSeats;
//		$noOfSeats = $_POST['txt_no_of_seats'];
		$result = $db->addBus($registration,$color,$model,$coach,$totalSeats,$normalSeats, $premiumSeats,$target_file);
		$successString = "The bus was added successfully";
		manageErrors($result, $successString, "bus");
		
	}
?>

<h2>Add Bus</h2>

<form method="POST" enctype="multipart/form-data">
				<?php if(isset($_GET['action']) && isset($_GET['id']) ) {
					$action = $_GET['action'];
					$registration = $_GET['id'];
					echo "<input type=\"hidden\" name=\"hid_registration\" value=\"$registration\">";
				} ?>




				<label for="txt_registration">Registration
					<input type="text" name="txt_registration" onchange="checkIfBusValid()" label="Enter Registration"
                           id="txt_registration"
                           value="<?php if(isset($registration)) {echo $registration;} ?>" required>
                    <span id="validRegistration" class="error"></span>
                </label>

    <div class="grid-x grid-padding-x">
        <div class="large-4 cell">
            <img id="bus_preview" onchange="readUrl(this)" src="<?php echo $imgUrl?>" alt="Bus Preview">
        </div>
        <div class="large-8 cell">
            <label for="fileToUpload">Upload image of bus
                <input type="file" name="fileToUpload" id="fileToUpload">
            </label>
        </div>
    </div>


				<div class="grid-x grid-padding-x">
					<div class="large-4 cell"><label>VIP/Premium Seats</label><input name="txt_seats_vip" id="txt_seats_vip"
                                                                                     type="number" min="0" max="50"
                                                                                     value="<?php echo $vip_seats?>" required
                                                                                     onchange="add()"></div>
					<div class="large-4 cell"><label>Regular Seats</label><input name="txt_seats_normal" id="txt_seats_normal"
                                                                                 type="number" value="<?php echo
                        $normalSeats?>" min="0"
                                                                                 max="50" required onchange="add()"></div>
						<div class="large-4 cell">
						<label for="txt_no_of_seats">No of Seats</label>
						<input type="number" min="0" max="50" disabled name="txt_no_of_seats" value="<?php echo $noOfSeats?>"
                               label="Enter
						Registration"
                               id="txt_no_of_seats"  required>	</div>
				</div>

				
				
				<label for="sel_color">Color
					<select name="sel_color" label="Color" id="sel_color">
							<option value="Red" <?php if($color == 'Red') {echo  "selected = 'selected'";} ?>
                            >Red</option>
							<option value="Black" <?php if($color == 'Black') {echo  "selected = 'selected'";}
							?>>Black</option>
							<option value="Orange" <?php if($color == 'Orange') {echo  "selected = 'selected'";}
							?>>Orange</option>
							<option value="Green" <?php if($color == 'Green') {echo  "selected = 'selected'";}
							?>>Green</option>
							<option value="Blue" <?php if($color == 'Blue') {echo  "selected = 'selected'";}
							?>>Blue</option>
					</select>
                </label>
				
				<label for="sel_selmodel">Model
                    <select name="sel_selmodel" id="">
                        <option value="Ford" <?php if($model == 'Ford') {echo  "selected = 'selected'";}
                        ?>>Ford</option>
                        <option value="Scania" <?php if($model == 'Scania') {echo  "selected = 'selected'";}
						?>>Scania</option>
                        <option value="Isuzu" <?php if($model == 'Isuzu') {echo  "selected = 'selected'";}
						?>>Isuzu</option>
                        <option value="Nissan" <?php if($model == 'Nissan') {echo  "selected = 'selected'";}
						?>>Nissan</option>
                        <option value="Toyota" <?php if($model == 'Toyota') {echo  "selected = 'selected'";}
						?>>Toyota</option>
                    </select>
                </label>

				
				<label for="sel_coach">Coach
					<select name="sel_coach" id="sel_coach">
						<option value="AC" <?php if($coach == 'AC') {echo  "selected = 'selected'";}
						?>>AC</option>
						<option valur="NON-AC" <?php if($coach == 'NON-AC') {echo  "selected = 'selected'";}
						?>>NON-AC</option>
					</select>
                </label>

				<input type="submit" name="btn_manage_bus" val="SAVE" class="button">			
			</form>
<script type="application/javascript">
    //Hide the
    var divValidRegistration = document.getElementById("validRegistration");
    divValidRegistration.style.display = "none";

    // function readUrl(input){
    //     if (input.files && input.files[0]) {
    //         let reader = new FileReader();
    //
    //         reader.onload = function(e) {
    //             document.getElementById('bus_preview').src=e.target.result;
    //         }
    //
    //         reader.readAsDataURL(input.files[0]); // convert to base64 string
    //     }
    // }

    function add() {
        var vipSeats = document.getElementById("txt_seats_vip").value;
        var normalSeats = document.getElementById("txt_seats_normal").value;
        var totalSeats =parseInt(vipSeats) + parseInt(normalSeats); //addition of two values
        document.getElementById("txt_no_of_seats").value = totalSeats;
    }

    function checkIfBusValid(){
        // Get the value input
      var x = document.getElementById("txt_registration").value;
        divValidRegistration.style.display = "block";
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("validRegistration").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "validate.php?validate=registration&registrationNo=" + x, true);
        xmlhttp.send();
    }

</script>