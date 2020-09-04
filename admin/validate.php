<?php
session_start();
require_once('src/class.db.php');
$db = new DB();
if(isset($_GET['validate'])){
 $validation = $_GET['validate'];
 switch ($validation){
	 case 'registration':
	 	if(isset($_GET['registrationNo'])){
	 		$registration = trim($_GET['registrationNo']);
		 	if(strlen($registration)!=8){
		 		echo "<p>The registration is not the correct length!. A valid registration number is 8 characters </p>";
			}else{
				$result = $db->checkIfUniqueRegistration($registration);
				if(is_int($result)){
					if($result>0){
						echo "<p class='error'><i></i>The registration number already exists. </p>";
					}else{
						echo "<p>Registration is ok</p>";
					}
				}else{
					echo "<p>{$result}</p>";
				}
		 		}
		 }else{
			echo "<p class='error'>The registration cannot be blank</p>";
		}

		 break;
	 case 'route':
	 	if(isset($_GET['start']) && isset($_GET['end'])){
	 		$start = strtolower(trim($_GET['start']));
	 		$stop = strtolower(trim($_GET['stop']));
	 		$result = $db->checkIfRouteExists($start, $stop);
	 		if(is_int($result)){
	 			if($result>0){
	 				echo "<p class='form-error'> A similar route exists</p>";
				}
			}else{
	 			echo "<p class='error'>$result</p>";
			}
		}
	 	break;
	 	default:
	 	echo "Something went wrong";
	 	break;
}
}
