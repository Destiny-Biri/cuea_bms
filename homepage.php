<?php 
		session_start();
		if(isset($_SESSION['dontgo'])){
			$_SESSION['dontgo']=NULL;
		}
		if(isset($_SESSION['username'])){}
			else{
				header('location: login.php');
			}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="assets/css/homepage.css">
</head>
<body>
	<?php 
		include('includes/inc.top_nav.php');
	?>
		<div class="hell">
		<h1 style="color: white;">Welcome to BMS Transport</h1><br>
		<a  href="book.php">Book Ticket</a>
	</div>
</body>
</html>