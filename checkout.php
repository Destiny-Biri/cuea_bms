<?php
session_start();
if(!isset($_SESSION['username'])) {	
	header('Location: login.php');
}
require_once('admin/src/class.db.php');
require_once('admin/src/class.order.php');
$email = $_SESSION['username'];
$db = new DB();
if(isset($_SESSION['booking'])){
	//Get the details of this booking
	$bookingId = $_SESSION['booking'];
	$order = $db->fetchOrderByBookingId($bookingId);
	//Get the details of this order 
	$orderDetails = $db->fetchOrderDetails($order->booking_id);
	
}

if(isset($_POST['btn_submitTxn'])){
  //Update the transaction
    $transactionCode = $_POST['txt_txnCode'];
    $amount = $order->amount;
    $receipt = $db->getReceipt($transactionCode);
    if(is_array($receipt)){
       //@TODO : An error occurred
        var_dump($receipt);
    }if($receipt instanceof Receipt){
        //Check if it is valid
        if($receipt->is_valid==0){
            //This transaction has already been used before
			//@TODO : An error occurred
			$result = $db->validateTransaction($transactionCode,
				$bookingId,$amount);
        }else{
            if((double)$receipt->amount == (double)$amount){
				$result = $db->validateTransaction($transactionCode,
					$bookingId,$receipt->amount, 'Complete');
            }
			$result = $db->validateTransaction($transactionCode,
				$bookingId,$receipt->amount, 'AwaitingBookingConfirmation');
        }
    }if(is_int($receipt)){
        //@TODO: Tell the user that the transaction
		$result = $db->validateTransaction($transactionCode,
			$bookingId,$amount);
    }


    header('Location:order_history.php');
}
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
    <div class="grid-x grid-margin-x grid-padding-x grid-padding-y">
        <div class="large-8 cell">
            <h5>INVOICE</h5>
            <ul class="no-bullet">
                <li>Invoice Ref : <?php echo $order->booking_id?></li>
                <li>Date : <?php echo $order->booking_time?></li>
                <li>Route : <?php echo $order->route_name?></li>
            </ul>
            <table>
                <thead>
                <tr>
                    <td>Seat No</td>
                    <td>Assigned To</td>
                    <td>Amount</td>
                </tr>
                <thead>
                <tbody>
                <?php
                foreach($orderDetails as $od){
                    echo "<tr>";
                    echo "<td>{$od->seat_id}</td>";
                    echo "<td>{$od->assignedTo}</td>";
                    echo "<td>{$od->price}</td>";
                    echo "</tr>";
                }
                echo "<tr>";
                echo "<td colspan='2'>TOTAL </td>";
                echo "<td>{$order->amount}</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td colspan='3'></td>";
                echo "</tr>";
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
				echo "<td>Terms &amp Conditions</td>";
                echo "<td></td>";
                echo "</tr>";
                echo "<tbody>";
                echo "<tr>";
                echo "<td><ol>
                    <li>The management reserves the right to cancel a journey</li>
                    <li>Your booking will only be valid once payment has been confirmed.</li>
                    <li>You are required to be at the pickup station 30mins before departure.</li>
                    <li>Use of alcohol and drugs is not permitted on the bus. Drunk passengers shall not be permitted
                        on the bus. </li>

                </ol></td>";
                echo "</tr>";
                echo "</tbody>";
                echo "</thead>";
                echo "</table>";
                ?>
                </tbody>
            </table>


        </div>
        <div class="large-4 cell">
            <div>
                <h5>Payment Instructions</h5>
                <p class="lead">By paying you accept our Terms and Conditions</p>
                <ol>
                    <li>Go To MPesa</li>
                    <li>Select Paybill</li>
                    <li>112366</li>
                    <li>Pay Kshs <strong><?php echo $order->amount?></strong></li>
                    <li>Enter the transaction code</li>
                </ol>
            </div>

            <div>
                <p>Enter the transaction code below</p>
                <form action="" method="post">
                    <label for="txt_txtCode">
                        <input type="text" name="txt_txnCode" id="txt_txtCode" required>
                    </label>

                    <input type="submit" value="SUBMIT" name="btn_submitTxn" class="button expanded">
                </form>
            </div>


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
