<?php
require_once('./src/class.db.php');
$db = new DB();
session_start();
if(isset($_POST['btn_login'])) {
	$username = stripslashes($_REQUEST['txt_username']);
	$password = stripslashes($_REQUEST['txt_password']);
	//Check if user exists
    $result = $db->checkIfAdminExists($username, $password);
	if($result == true) {
	    $_SESSION['admin'] = true;
		$_SESSION['username'] = $username;
		header("Location: index.php");	
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
<div class="loginbox">
	<h1>Admin Login</h1><br><br>
	<form method="POST">	
		Username:<br><input type="text" name="txt_username"  placeholder="Enter Username" required ><br>
		Password:<br><input type="Password" name="txt_password" placeholder="Enter Password"  required>
		<br><br>
		<input type="submit" name="btn_login" value="Login">
	</form>
</div>
</body>
</html>