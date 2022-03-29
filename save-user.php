<?php
$title = 'Saving new user...';
require 'includes/header.php';

// get form inputs from registration page
$username = $_POST['username'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

// flag for validating inputs
$valid = true;

// input validation
// if username, password, or confirmPassword were not entered, inform the user of their error
if (empty($username)) {
    echo '<p>You must enter a username.</p>';
    $valid = false;
}
if (empty($password)) {
    echo '<p>You must enter a password.</p>';
    $valid = false;
}
if (empty($confirmPassword)) {
    echo '<p>Your passwords do not match.';
    $valid = false;
}

// if the user entered valid inputs, begin the process of saving them to the users table in the database
if ($valid) {
    try {
        // connect to the database
        require 'includes/db.php';

        // verify that the username does not already exist in the table
        $sql = "SELECT *
                FROM cmsusers
                WHERE username = :username";
        $cmd = $db->prepare($sql);
        $cmd->bindParam(':username', $username, PDO::PARAM_STR, 100);
        $cmd->execute();
        $user = $cmd->fetch();

        // if the username already exists, send the user to the login page with a descriptive message
        if ($user) {
            $db = null;
            header('location:login.php?invalid=2');
        }
        // if the username is valid, then hash the password and save the user to the table
        else {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO cmsusers (username, password)
                    VALUES (:username, :password)";
            $cmd = $db->prepare($sql);
            $cmd->bindParam(':username', $username, PDO::PARAM_STR, 100);
            $cmd->bindParam(':password', $password, PDO::PARAM_STR, 255);
            $cmd->execute();
            
            // disconnect from the database
            $db = null;

            // redirect the user to the login page
            header('location:login.php');
        }
    } catch (Exception $error) {
        // redirect the user to the error page if the database connection fails
        header("location:error.php");
    }
}