<?php 
		session_start();
		if(isset($_SESSION['dontgo'])){
			$_SESSION['dontgo']=NULL;
		}
		if(isset($_SESSION['username'])){
		    $name = $_SESSION['name'];
        }
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
		<p class="lead" style="color: white; font-size: 2.2em">Welcome <?php echo $name ?> to BMS Transport</p><br>
		<a  href="book.php">Book Ticket</a>
	</div>
</body>
</html>