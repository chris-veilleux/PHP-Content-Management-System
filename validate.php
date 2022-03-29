<?php
// get form inputs from login page
$username = $_POST['username'];
$password = $_POST['password'];

try {
    // connect to the database
    require 'includes/db.php';

    // search for the username in the database table
    $sql = "SELECT *
            FROM cmsusers
            WHERE username = :username";
    $cmd = $db->prepare($sql);
    $cmd->bindParam(':username', $username, PDO::PARAM_STR, 100);
    $cmd->execute();
    $user = $cmd->fetch();

    // if the username is not found in the table, redirect the user to the login page
    if (!$user) {
        $db = null;
        header('location:login.php?invalid=1');
    }
    // if the username is found, then hash and compare the password from the login page with the password from the database
    else {
        if (!password_verify($password, $user['password'])) {
            // if the passwords don't match, redirect the user to the login page
            $db = null;
            header('location:login.php?invalid=1');
        }
        else {
            // if the passwords match, save the username and userId in session variables
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['userId'] = $userId['userId'];

            // redirect to the admin dashboard page
            header('location:dashboard.php');

        }
    }


} catch (Exception $error) {
    // redirect the user to the error page if the database connection fails
    header("location:error.php");
}