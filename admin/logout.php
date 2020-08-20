<?php
session_start();
unset($_SESSION['username']);
session_destroy();
//redirect the person to the login page
header('Location: login.php');