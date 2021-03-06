<?php
require_once ('src/class.db.php');
//Create a new instance of the database class
$db = new DB();
$users = $db->fetchAllUsers();
?>
<div class="grid-x grid-padding-x">
    <div class="large-8 cell">
        <h2>Manage Users</h2>
    </div>
    <div class="large-4 cell">
        <a class="button" href="index.php?action=add&view=users"><i class="fas fa-user"></i> Add New User</a>
    </div>
</div>
<p class="lead">Use this section to manage admin users and customers</p>
<?php
require ('pages/inc.feedback.php');
?>
<table>
    <thead>
        <tr>
            <td>Email</td>
            <td>Name</td>
            <td>Mobile</td>
            <td>UserType</td>
            <td>Status</td>
            <td>Details</td>
<!--            <td>Edit</td>-->
        </tr>

    </thead>
    <tbody>
    <?php
    foreach ($users as $user){
		$modalId = 1;
		$url = "index.php?action=delete&view=users&userId={$user['userId']}";
		displayDeleteModal($modalId, $url);
        if($user['status'] == 0) {
            $status = "Disabled";
        }else{
            $status = "Enabled";
        }
        echo "<tr>";
        echo "<td>{$user['email']}</td>";
        echo "<td>{$user['name']}</td>";
        echo "<td>{$user['mobile']}</td>";
        echo "<td>{$user['userType']}</td>";
        echo "<td>{$status}</td>";
        echo "<td><a href='index.php?action=detail&view=users&id={$user['email']}'>View Details</a></td>";
//        echo "<td>Enable | <a data-open='modal_$modalId'>Disabled</a></td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
