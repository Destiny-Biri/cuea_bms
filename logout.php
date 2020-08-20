<?php 
//Destroy the username session
unset($_SESSION['username']);
session_destroy();
//redirect the person to the login page
header('Location: login.php');