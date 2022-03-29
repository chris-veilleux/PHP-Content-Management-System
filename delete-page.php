<?php
require 'includes/auth.php';

try {
    // retrieve and validate the id of the page to be deleted from the url
    if (isset($_GET['pageId'])) {
        if (is_numeric($_GET['pageId'])) {
            // connect to the database
            require 'includes/db.php';

            // sql statement for deleting the specified record
            $sql = "DELETE FROM pages
                    WHERE pageId = :pageId";
            $cmd = $db->prepare($sql);
            $cmd->bindParam(':pageId', $_GET['pageId'], PDO::PARAM_INT);
            $cmd->execute();

            // disconnect from database
            $db = null;

        }
    }
    // redirect to list of pages once record is deleted OR if the url param is invalid
    header('location:pages.php');

} catch (Exception $error) {
    header('location:error.php');
}