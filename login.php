<?php
	require_once('admin/src/class.db.php');
	session_start();
	if(isset($_POST['submit'])){
		//@TODO: Trim and sanitize for database
		$pass = $_POST['txt_pass'];
		$email = $_POST['txt_email'];
		$db = new DB();
		$result = $db->checkIfUserExists($email, $pass);
		$userDetail = $db->fetchUserDetailByEmail($email);
		if($result == true) {
			$_SESSION['username'] = $email;
			$_SESSION['name'] = $userDetail['name'];
			// Redirect if a user was found
			header('Location: homepage.php');
		}

	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
<div class="loginbox">
	<h1>Login</h1>
	<form method="POST">
	<label for="txt_email">Username	
		<input type="text" name="txt_email"  placeholder="Enter Username" id="txt_email" required>
		</label>
		
		<label for="txt_password">Password
		<input type="Password" name="txt_pass" placeholder="Enter Password"  required>
		</label>
		
		<input type="submit" name="submit" value="Login">
	</form><br>

	<a href="registration.php">Create Account? </a><br/>
	<a href="admin/login.php">Admin Login</a>
</div>
</body>
</html>