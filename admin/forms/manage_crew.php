<?php
require_once ('src/class.db.php');

if(isset($_POST['btn_manageCrew'])){
    $driverName = $_POST['txt_crew_name'];
    $crew_type = $_POST['sel_crewType'];
    $db = new DB();
    $result = $db->addNewCrew($driverName,$crew_type);
    if($result){
        header('Location:index.php?action=view&view=crew');
    }
}
?>
<h3>Manage Drivers and Conductors</h3>
<form action="" method="POST">
    <label for="txt_crew_name">Driver Name
        <input type="text" name="txt_crew_name" required>
    </label>

    <label for="sel_crewType">Role
        <select name="sel_crewType">
            <option value="Driver">Driver</option>
            <option value="Conductor">Conductor</option>
        </select>
    </label>

    <input type="submit" name="btn_manageCrew" class="button" value="SAVE">
</form>