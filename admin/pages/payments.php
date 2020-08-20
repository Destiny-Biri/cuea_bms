<?php
require_once ('src/class.db.php');
$db = new DB();
$result = $db->fetchAllTransactions();
//var_dump($result);
?>
<h2>Payments</h2>
<?php
if(count($result) == 0) {
    echo "<p class='lead'> You have not received any payments.</p>";
}else{
    echo "<table>";
    echo "<thead>";
    echo "<tr>";
    echo "<td>Date</td>";
    echo "<td>Amount</td>";
    echo "<td>Booking Id</td>";
    echo "<td>Transaction Code</td>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($result as $res){
        echo "<tr>";
            echo "<td>{$res['transaction_date']}</td>";
            echo "<td>{$res['amount']}</td>";
            echo "<td>{$res['booking_id']}</td>";
            echo "<td>{$res['transaction_code']}</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
}
?>
