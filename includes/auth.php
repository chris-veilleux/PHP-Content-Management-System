<?php
// call session_start
session_start();

// check to see if a username var exists for the session. If so, they are authenticated. If not, redirect to the login page
if (empty($_SESSION['username'])) {
    header('location:login.php');
    exit();
}