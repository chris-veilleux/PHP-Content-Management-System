<?php
session_start();
// remove the current session
session_destroy();
// redirect to the login page
header('location:login.php');
?>