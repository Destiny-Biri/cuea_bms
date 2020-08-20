<?php 
require_once('admin/src/class.db.php');
session_start();
if(isset($_POST['btn_register'])){
	$name = $_POST['txt_name'];
	$mobile = $_POST['txt_number'];
	$email = $_POST['txt_email'];
	$pass1 = $_POST['txt_pass1'];
	$pass2 = $_POST['txt_pass2'];
	$userType = 'customer';
	$db = new DB();
	//Check if the passwords are similar
	if($pass1 == $pass2) {
	    //Ensure that the passwords are long
        if(strlen($pass1) > 6) {
            $result = $db->addUser($email, $pass1,$name,$mobile,$userType);
            if(!(is_string($result))){
                $_SESSION['username']= $email;
                $_SESSION['name'] = $name;
                header('location: homepage.php');
            }else{
                $_SESSION['error'] =$result;
            }
        }else{
            $_SESSION['error'] ="Password to short";
        }


	}else{
        $_SESSION['error'] ="Password dont match";
	}
	
	
}
?>
<html>
<head>
	<title>Registration</title>
	<link rel="stylesheet" type="text/css" href="assets/css/registration.css">
    <link rel="stylesheet" type="text/css" href="validation.css">
</head>
<body>

	<div class="loginbox">

		<h1>Registration</h1>
<!--        <div id="message">-->
<!--            <h3>Password must contain the following:</h3>-->
<!--            <p id="letter" class="invalid">A <b>lowercase</b> letter</p>-->
<!--            <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>-->
<!--            <p id="number" class="invalid">A <b>number</b></p>-->
<!--            <p id="length" class="invalid">Minimum <b>8 characters</b></p>-->
<!--        </div>-->

        <?php
        if(isset($_SESSION['error'])){
            echo "<div class='callout error'>";
            echo "<p>{$_SESSION['error']}</p>";
            echo "</div>";
        }

        ?>
<form action="registration.php" method="POST">
	
	Name:<br> <input type="text" name="txt_name" placeholder="Enter Name" required  ><br>
	
	Mobile Number: <br><input type="tel" name="txt_number" placeholder="Enter Number"  required ><br>

	Email: <br><input type="email" name="txt_email" placeholder="Enter Email Address" required><br>

    Password <br><input type="password" id="txt_pass1" name="txt_pass1" placeholder="Enter Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>



	Confirm Password: <br><input type="Password" name="txt_pass2" placeholder="Enter Password Again" required><br>

	<br><input type="Submit" name="btn_register" value="Register"><br><br>
	<a href="login.php">Already have an account!</a>
</form>
</div>
    <script>
        var myInput = document.getElementById("txt_pass1");
        var letter = document.getElementById("letter");
        var capital = document.getElementById("capital");
        var number = document.getElementById("number");
        var length = document.getElementById("length");

        // When the user clicks on the password field, show the message box
        myInput.onfocus = function() {
            document.getElementById("message").style.display = "block";
        }

        // When the user clicks outside of the password field, hide the message box
        myInput.onblur = function() {
            document.getElementById("message").style.display = "none";
        }

        // When the user starts to type something inside the password field
        myInput.onkeyup = function() {
            // Validate lowercase letters
            var lowerCaseLetters = /[a-z]/g;
            if(myInput.value.match(lowerCaseLetters)) {
                letter.classList.remove("invalid");
                letter.classList.add("valid");
            } else {
                letter.classList.remove("valid");
                letter.classList.add("invalid");
            }

            // Validate capital letters
            var upperCaseLetters = /[A-Z]/g;
            if(myInput.value.match(upperCaseLetters)) {
                capital.classList.remove("invalid");
                capital.classList.add("valid");
            } else {
                capital.classList.remove("valid");
                capital.classList.add("invalid");
            }

            // Validate numbers
            var numbers = /[0-9]/g;
            if(myInput.value.match(numbers)) {
                number.classList.remove("invalid");
                number.classList.add("valid");
            } else {
                number.classList.remove("valid");
                number.classList.add("invalid");
            }

            // Validate length
            if(myInput.value.length >= 8) {
                length.classList.remove("invalid");
                length.classList.add("valid");
            } else {
                length.classList.remove("valid");
                length.classList.add("invalid");
            }
        }
    </script>
</body>
</html>
<?php
if(isset($_SESSION['error'])){
    unset($_SESSION);
}
?>