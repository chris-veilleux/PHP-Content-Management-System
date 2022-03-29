<?php

try {
    // get form inputs from registration page using the $_POST array
    $userId = $_POST['userId'];
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

    // if the user entered valid inputs, begin the process of either saving them to the users table in the database or updating the existing record
    if ($valid) {
        // connect to the database
        require 'includes/db.php';

        // if a new user is to be added:
        if (empty($userId)) {
            
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
        }

        // if an existing user is to be modified:
        else {
            // require authentication, so that anonymous users cannot edit existing users
            require 'includes/auth.php';
            // verify that the username does not already exist for another user in the table
            $sql = "SELECT *
                    FROM cmsusers
                    WHERE username = :username AND userId != :userId";
            $cmd = $db->prepare($sql);
            $cmd->bindParam(':userId', $userId, PDO::PARAM_INT);
            $cmd->bindParam(':username', $username, PDO::PARAM_STR);
            $cmd->execute();
            $user = $cmd->fetch();

            // if the username already exists for another user, return the user to the list of administrators
            if ($user) {
                $db = null;
                header('location:admins.php?message=1');
            }
            // if the username is valid, then hash the password and save the changes
            else {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE cmsusers
                        SET username = :username, password = :password
                        WHERE userId = :userId";
                $cmd = $db->prepare($sql);
                $cmd->bindParam(':username', $username, PDO::PARAM_STR, 100);
                $cmd->bindParam(':password', $password, PDO::PARAM_STR, 255);
                $cmd->bindParam(':userId', $userId, PDO::PARAM_INT);
                $cmd->execute();

                // disconnect from the database
                $db = null;

                // redirect the user to the list of administrators
                header('location:admins.php?message=2');
            }
        }

         
    }
} catch (Exception $error) {
    // if the database connection fails, redirect user to error page
    header('location:error.php');
}
