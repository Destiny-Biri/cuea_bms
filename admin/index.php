<?php
session_start();
//Check if a session exists 
if(!isset($_SESSION['username']) || !isset($_SESSION['admin']) ){
	header('Location:login.php');
}
require_once 'src/class.db.php';
require_once 'src/functions.php';
require_once 'src/salesByBus.php';
if(isset($_GET['action'])){
  $action = $_GET['action'];
  if($action == 'delete'){
    if(isset($_GET['view'])){
		$view = $_GET['view'];
        switch ($view){
            case 'bus':
                if(isset($_GET['reg'])){
                    $registration = $_GET['reg'];
                    $db = new DB();
                    $result = $db->deleteBus($registration);
                    if(is_bool($result)){
                        $status = true;
                        $response = "The bus was successfully deleted";
                    }else{
						$status = false;
						$response = $result;
                    }
                    header("Location:index.php?action=view&view=bus&status=$status&response=$response");
                }
                break;
            case 'journey':
				if(isset($_GET['journeyId'])){
					$journeyId = $_GET['journeyId'];
					$db = new DB();
					$result = $db->deleteJourney($journeyId);
					if(is_bool($result)){
						$status = true;
						$response = "The journey was successfully deleted";
					}else{
						$status = true;
						$response = $result;
					}
					header("Location:index.php?action=view&view=trip&status=$status&response=$response");
				}
                break;
            case 'route':
				if(isset($_GET['routeId'])){
					$routeId = $_GET['routeId'];
					$db = new DB();
					$result = $db->deleteRoute($routeId);
					if(is_bool($result)){
						$status = true;
					    $response = "The route was successfully deleted";
					}else{
					    $status = false;
					    $response = $result;

					}
					header("Location:index.php?action=view&view=route&status={$status}&response={$response}");
				}
				break;
			case 'crew':
				if(isset($_GET['crewId'])){
					$crewId = $_GET['crewId'];
					$db = new DB();
					$result = $db->deleteCrewMember($crewId);
					if(is_bool($result)){
						$status = true;
						$response = "The member was successfully deleted";
					}else{
						$status = false;
						$response = $result;

					}
					header("Location:index.php?action=view&view=crew&status={$status}&response={$response}");
				}
				break;
        }
    }
  }
  if ($action == 'validate'){
      if(isset($_GET['booking_id'])){
          $booking_id = (int)$_GET['booking_id'];
          $db = new DB();
          $status = 'Complete';
          $result = $db->confirmBooking($booking_id, $status);
          if(is_bool($result)){
              $status = $result;
              $response = "THe booking was confirmed";
          }else{
              $status = false;
              $response = $result;
          }
      }
      header("Location: index.php?action=view&view=payments&status=$status&response=$response");

  }
}
?>
<html lang="en">
<head>
	<title>Admin</title>
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="css/app.css">
	<link rel="stylesheet" href="css/screen.css">
	<link rel="stylesheet" href="fontawesome/css/all.css">
	<link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Montserrat:semibold,regular,bold">
	<!-- <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="grid-container full">
    <div class="">
				<div class="top-bar">
					<div class="top-bar-left">
						<ul class="menu">
							<li><img alt="logo" height="50" width="50" src="images/CAPTURE.png"></li>
							<li><a href="index.php"><i class="fas fa-home"></i> DASHBOARD</a></li>
							<li><a href="index.php?action=view&view=bookings"><i class="fas fa-book"></i> BOOKINGS</a></li>
							<li><a href="index.php?action=view&view=payments"><i class="fas fa-cash-register"></i> PAYMENTS</a></li>
                            <li><a href="index.php?action=view&view=reports"><i class="fas fa-cash-register"></i>
                                    REPORTS</a></li>
						</ul>
					</div><!--End of top bar left-->
					<div class="top-bar-right">
						<ul class="menu">
<!--							<li><a href=""><i class="fas fa-user-cog"></i> Account Settings</a></li>-->
							<li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Sign Out</a></li>
						</ul>
					</div>
				</div><!-- End of topbar-->
	</div><!--End of container-->
</div>
		
		
<div class="grid-container full">
	<div class="grid-x grid-padding-x grid-padding-y">
	<div id="sidebar" class="large-2 cell"><!--Sidenav-->
		<ul class="menu vertical">
			<li><a title="Add and edit vehicles in your fleet." href="index.php?action=view&view=bus">Manage Vehicles</a></li>
			<li><a href="index.php?action=view&view=route">Manage Routes</a></li>
			<li><a href="index.php?action=view&view=trip">Manage Trip</a></li>
			<li><a href="index.php?action=view&view=crew">Manage Crew</a></li>
			<li><a href="index.php?action=view&view=users">Manage Users</a></li>
		</ul>
	</div><!--End of side nav-->

	<div id="content" class="large-10 cell"><!--Main content-->
        <?php

					if(isset($_GET['view'])){
						$view = $_GET['view'];
						switch($view){
                            case 'reports':
                                include ('pages/reports.php');
                                break;
                            case 'bookings':
                                if(isset($_GET['action'])){
									$action = $_GET['action'];
									switch ($action){
                                        case 'view':
                                            include ('pages/booking.php');
                                            break;
                                        default:
											include ('pages/booking.php');
                                            break;
                                    }
                                }
                                break;
                            case 'payments':
								if(isset($_GET['action'])){
									$action = $_GET['action'];
									switch ($action){
										case 'view':
											include ('pages/payments.php');
											break;
										default:
											include ('pages/payments.php');
											break;
									}
								}
								break;
                                break;
							case 'bus':
								//Check the required action
								if(isset($_GET['action'])){
									$action = $_GET['action'];
									switch($action){
										case 'view':
											include('pages/bus.php');
										break;
										case 'add':
										    include('forms/manage_bus.php');
										break;
										case 'edit':

											include('forms/manage_bus.php');
										break;
									}
								}
							break;
							case 'route':
								//Check the required action
								//Check the required action
								if(isset($_GET['action'])){
									$action = $_GET['action'];
									switch($action){
										case 'view':
											include('pages/route.php');
										break;
										case 'add':
											include ('pages/inc.feedback.php');
											include('forms/manage_routes.php');
										break;
                                        case 'edit':
                                            if(isset($_GET['routeId'])){
												include "forms/manage_routes.php";
                                            }
                                            break;

									}
								}
							break;
							case 'trip':
								if(isset($_GET['action'])){
									$action = $_GET['action'];
									switch($action){
										case 'view':
											include('pages/trip.php');
										break;
										case 'add':
											include ('pages/inc.feedback.php');
											include('forms/manage_schedule.php');
										break;
                                        case 'detailed':
                                            include ('pages/detailed_trip.php');
                                            break;
									}
								}
							break;
							case 'crew':
								if(isset($_GET['action'])){
									$action = $_GET['action'];
									switch($action){
										case 'view':
											include('pages/crew.php');
										break;
										case 'add':
											include ('pages/inc.feedback.php');
											include('forms/manage_crew.php');
										break;
									}
								}
							break;
                            case 'users':
                                if(isset($_GET['action'])){
                                    $action = $_GET['action'];
                                    switch($action){
                                        case 'view':
                                            include('pages/users.php');
                                            break;
                                        case 'add':
											include ('pages/inc.feedback.php');
                                            include('forms/manage_users.php');
                                            break;
                                        case 'detail':
                                            include('forms/manage_users.php');
                                            break;
                                    }
                                }
                                break;
						}
					}else{
						include('pages/dashboard.php');
					}
				?>
				
			</div><!--End of content-->	
	</div>
</div>

<div id="footer" class="grid-container full">
	<div class="grid-x grid-padding-x grid-padding-y">
		<div class="large-8 cell">
		<p class="text-center lead">Bus Management System &copy <?php echo Date('Y') ?></p>
			<p class="lead text-center">A Final Project by Destiny Biringanine Mulumeoderhwa</br>
				in partial fulfilment of BSc(Computer Science)</p>		
		</div>
			
		<div class="large-4 cell">
			<p>School Id: 1029000</p>		
		</div>
		
	</div>				
</div>

	

	<script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/what-input.js"></script>
		<script src="js/vendor/foundation.js"></script>

    <script src="js/app.js"></script>
</body>
</html>
<?php


?>