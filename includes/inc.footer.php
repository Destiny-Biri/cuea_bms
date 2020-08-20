<div class="header">
		<div class="logo">
				<img src="image/capture.png">
		</div>
		<ul>
				<?php
				session_start();
				$un=$_SESSION['username'];
				$db=new mysqli('localhost','root','','bus_management_system') or die("Unable to Connect to Database");  
				$query=" SELECT * FROM customer2 where customer_id='$un'";
				$result=mysqli_query($db, $query);
				if(mysqli_num_rows($result)==1){
					?>
					<li><a href="homepage.php">Home</a></li>
					<li><a href="contact.php">Contact Us</a></li>
					<li><a href="about.php">About Us</a></li>
					<?php
				}
				else{
					?>
					<li><a href="ce_homepage.php">Home</a></li>
					<li><a href="e_view_tickets.php">Booked Tickets</a></li>
					<li><a href="e_about.php">About Us</a></li>
					<?php 
				}
				?>
				
				
				<li><a href="logout.php"> Log Out</a></li>
		</ul>
	</div>