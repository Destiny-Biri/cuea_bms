<?php
require_once ('src/class.db.php');

if(isset($_POST['btn_manageCrew'])){
    $driverName = trim($_POST['txt_crew_name']);
    $crew_type = trim($_POST['sel_crewType']);
    $staff_id = trim($_POST['txt_staff_id']);
    $db = new DB();
    $result = $db->addNewCrew($driverName,$crew_type);
    if($result){
        header('Location:index.php?action=view&view=crew&status=1&response=A new member was added.');
    }
}
?>
<?php

$staff_id="";
$crew_name ="";
$crew_type ="";

?>


<h3>Manage Drivers and Conductors</h3>
<form action="" method="POST">
    <label for="txt_crew_name">Driver Name
        <input type="text" name="txt_crew_name" value="<?php echo $crew_name?>" required>
    </label>

    <label for="txt_staffId">
        <input type="text" name="txt_staff_id" value="<?php echo $staff_id?>" required>
    </label>

    <label for="sel_crewType">Role
        <select name="sel_crewType">
            <option value="Driver" <?php if($crew_type == 'Driver') {echo "selected 'selected' ";}?>>Driver</option>
            <option value="Conductor" <?php if($crew_type == 'Conductor') {echo "selected 'selected' ";
            }?>>Conductor</option>
        </select>
    </label>

    <input type="submit" name="btn_manageCrew" class="button" value="SAVE">
</form>