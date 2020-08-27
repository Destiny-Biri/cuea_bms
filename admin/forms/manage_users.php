<?php

require_once ('src/class.db.php');
if(isset($_POST['btn_saveuser'])){
   $db = new DB();
   if(isset($_POST['hid_userId'])){
       $status = (int)$_POST['rad_status'];
	   $userId = (int)$_POST['hid_userId'];
	   $email = $_POST['txt_email'];
	   $mobile = $_POST['txt_mobile'];
	   $name = $_POST['txt_name'];
	   //Add the user
	   $result = $db->updateUser($email, $name, $mobile,$userId, $status);
	   manageErrors($result,"The user was updated successfully","users");
   }else{
       $email = $_POST['txt_email'];
	   $mobile = $_POST['txt_mobile'];
	   $name = $_POST['txt_name'];
	   $password = $_POST['txt_password'];
	   $userType = "customer";
	   //Add the user
	   $result = $db->addNewUser($email, $name, $mobile, $password,$userType);
	   manageErrors($result,"The user was updated successfully","users");
   }

}

?>

<?php

$email = "";
$name = "";
$mobile = "";
$userId = "";
$password = "";
$status = 1;

if(isset($_GET['id'])){
    $email = $_GET['id'];
    $db = new DB();
    $result = $db->fetchUserDetailByEmail($email);
    $name = $result['name'];
    $mobile = $result['mobile'];
    $userId = $result['userId'];
    $status = $result['status'];
echo  "<h2>Edit User</h2>";
}else{
	echo  "<h2>Add User</h2>";
}
?>
<a href="index.php?action=view&view=users" class="button">BACK TO USERS</a>
<form method="POST">
    <?php
    if(isset($_GET['id'])){
        echo "<input type=\"hidden\" name=\"hid_userId\" value=\"$userId\">";
    }
    ?>


    <label for="txt_email">Name
        <input type="text" name="txt_name" value="<?php echo $name ?> ">
    </label>
    <label for="txt_email">Email
        <input type="text" name="txt_email" value="<?php echo $email ?> ">
    </label>
    <label for="txt_email">Mobile
        <input type="text" name="txt_mobile" value="<?php echo $mobile ?> ">
    </label>
    <label for="txt_password">Password
        <input type="text" name="txt_password" value="<?php echo $password ?> ">
    </label>

    <label for="rad_status">
        <input type="radio" value="0"  name="rad_status" <?php if($status==0){echo "checked='checked'";} ?>>Disabled
    </label>
    <label for="rad_status" >
        <input type="radio" value="1" name="rad_status" <?php if($status==1){echo "checked='checked'"; } ?>>Enabled
    </label>

    <input type="submit" name="btn_saveuser" value="SUBMIT" class="button">
</form>
