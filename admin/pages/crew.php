<?php
require_once ('src/class.db.php');
//Create a new instance of the database class
$db = new DB();
$crewMembers = $db->fetchAllCrew();
?>
<div class="grid-x grid-padding-x">
<div class="large-8 cell">
<h2>Manage Crew</h2>
</div>
<div class="large-4 cell">
<a class="button" href="index.php?action=add&view=crew"><i class="fas fa-user"></i> Add Crew Member</a>
</div>
</div>
<p class="lead">Use this section to manage the drivers and the conductors</p>
<?php
require ('pages/inc.feedback.php');
?>
<table>
    <thead>
    <tr>
        <td>Crew Name</td>
        <td>Crew Type</td>
        <td>Action</td>
    </tr>

    </thead>
    <tbody>
    <?php
    foreach ($crewMembers as $crew){
        echo "<tr>";
        echo "<td>{$crew->crew_name}</td>";
        echo "<td>{$crew->crew_type}</td>";
        echo "<td><a href='index.php?action=delete&view=crew&crewId=$crew->crew_id'>Delete</a></td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>