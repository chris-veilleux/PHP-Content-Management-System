<?php
require 'includes/auth.php';

try {
    // retrieve and validate the id of the user to be deleted from the url
    if (isset($_GET['userId'])) {
        if (is_numeric($_GET['userId'])) {
            // connect to the database
            require 'includes/db.php';

            // sql statement for deleting the specified user
            $sql = "DELETE FROM cmsusers
                    WHERE userId = :userId";
            $cmd = $db->prepare($sql);
            $cmd->bindParam(':userId', $_GET['userId'], PDO::PARAM_INT);
            $cmd->execute();

            // disconnect from database
            $db = null;
        }
    }

    // redirect to list of users once user is deleted OR if the url param is invalid
    header('location:admins.php');

} catch (Exception $error) {
    // if the database connection fails, redirect to the error page
    header('location:error.php');
}