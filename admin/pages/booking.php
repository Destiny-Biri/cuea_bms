<?php
require_once ('src/class.db.php');
$db = new DB();
$result = $db->fetchAllOrders();
?>
<h2>Bookings</h2>
<?php
if(count($result) == 0) {
    echo "<p class='lead'> No bookings have been made.</p>";
}else{
    echo "<table>";
    echo "<thead>";
    echo "<tr>";
    echo "<td>Date</td>";
    echo "<td>Customer Email</td>";
    echo "<td>Journey</td>";
    echo "<td>Amount</td>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($result as $res){
//        $formattedDate = Date('d m -y', $res->booking_time);
        echo "<tr>";
        echo "<td>{$res->booking_time}</td>";
        echo "<td>{$res->email}</td>";
        echo "<td>{$res->route_name}</td>";
        echo "<td>{$res->amount}</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
}
?>
