<?php
session_start();
require_once('admin/src/class.db.php');
require_once('admin/src/class.order.php');
//@TODO fetch the orders for a user with the username currently signed in
$userId = $_SESSION['username'];
$db = new DB();

$orderHistory = $db->fetchOrdersByEmail($userId);

?>
    <!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" href="assets/css/foundation.css">
        <link rel="stylesheet" href="assets/css/app.css">
        <link rel="stylesheet" type="text/css" href="assets/css/book.css">
        <link rel="stylesheet" href="fontawesome/css/all.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:semibold,regular,bold">
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">


    </head>
<body>
<?php include('includes/inc.top_nav.php'); ?>
<div class="grid-container">
    <div class="grid-x grid-padding-x grid-padding-y">
        <div class="large-12 cell">
            <?php
            if(isset($_GET['orderId'])){
                $orderId = (int)$_GET['orderId'];
                $orderDetails = $db->fetchOrderDetails($orderId);
				$order = $db->fetchOrderByBookingId($orderId);
                $noOfSeats = count($orderDetails);
//                var_dump($orderDetails);
                echo "<h2>Booking Details for Order $orderId</h2>";
                echo "<a href=\"order_history.php\" class='button'>Back to Booking History</a>";
                echo "<p class='lead'>You have booked $noOfSeats seats.</p>";
                echo "<ul class='no-bullet'>";
                echo "<li>Route : {$order->route_name}</li>";
				echo "<li>Vehicle : {$order->journey->vehicle->registration}</li>";
				echo "<li>Departure Date : {$order->journey->departureDate}</li>";
				echo "<li>Departure Time : {$order->journey->departureTime}</li>";
				echo "<li>Order Status : {$order->order_status}</li>";
				echo "<li>Booking Date : {$order->booking_time}</li>";
                echo "</ul>";
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                echo "<td>Seat Id</td>";
				echo "<td>Amount</td>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                foreach ($orderDetails as $orderDetail){
					echo "<tr>";
					echo "<td>$orderDetail->seat_id</td>";
					echo "<td>$orderDetail->price</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            }else {
				echo "<h2>Booking History</h2>";
				if (count($orderHistory, COUNT_RECURSIVE) > 0) {
					echo "<table>";
					echo "<thead>";
					echo "<tr>";
					echo "<td>Order No</td>";
					echo "<td>Date</td>";
					echo "<td>Route</td>";
					echo "<td>Amount</td>";
					echo "<td>Status</td>";
					echo "<td>Actions</td>";
					echo "</tr>";
					echo "</thead>";
					echo "<tbody>";
					foreach ($orderHistory as $order) {
						echo "<tr>";
						echo "<td>{$order->booking_id}</td>";
						echo "<td>{$order->booking_time}</td>";
						echo "<td>{$order->route_name}</td>";
						echo "<td>{$order->amount}</td>";
						echo "<td>{$order->order_status}</td>";
						echo "<td><a href='order_history.php?orderId={$order->booking_id}' title='view details'>View details</td>";
						echo "</tr>";
					}
					echo "</tbody>";
					echo "</table>";
				}
				else {
					echo "<p>You do not have any booked any bus.</p>";
				}
			}
			?>
        </div>
    </div>
</div>

<script src="assets/js/vendor/jquery.js"></script>
<script src="assets/js/vendor/what-input.js"></script>
<script src="assets/js/vendor/foundation.js"></script>
<script src="assets/js/vendor/foundation.equalizer.min.js"></script>
<script src="assets/js/app.js"></script>

</body>
</html>
