<?php
require 'includes/auth.php';
$title = 'Saving page...';
require 'includes/header.php';

try {
    // retrieve the form inputs and store them in local variables from page-info.php using the $_POST array
    $pageId = $_POST['pageId'];
    $pageTitle = $_POST['pageTitle'];
    $pageContent = $_POST['pageContent'];

    // flag for input validation
    $valid = true;

    // input validation
    if (empty($pageTitle)) {
        echo "A page title is required.";
        $valid = false;
    } else if (strlen($pageTitle) > 20) {
        echo "Page titles must not be more than 20 characters.";
        $valid = false;
    }

    if (empty($pageContent)) {
        echo "Page content is required.";
        $valid = false;
    }


    // if the input is valid, either update the existing page or add a new page to the pages table in the database
    if ($valid) {
        // connect to the database
        require 'includes/db.php';

        // if adding a new page, use an insert statement
        if (empty($pageId)) {
            $sql = "INSERT INTO pages (pageTitle, pageContent)
                    VALUES (:pageTitle, :pageContent)";
        } 
        // if modifying an existing page, use an update statement
        else {
            $sql = "UPDATE pages
                    SET pageTitle = :pageTitle, pageContent = :pageContent
                    WHERE pageId = :pageId";
        }

        // prepare the sql statement and bind params
        $cmd = $db->prepare($sql);
        $cmd->bindParam(':pageTitle', $pageTitle, PDO::PARAM_STR, 20);
        $cmd->bindParam(':pageContent', $pageContent, PDO::PARAM_STR);

        // bind the pageId param if it exists
        if (!empty($pageId)) {
            $cmd->bindParam(':pageId', $pageId, PDO::PARAM_INT);
        }

        // execute the command and disconnect from the database
        $cmd->execute();
        $db = null;

        // redirect to the list of pages
        header('location:pages.php');
    }
}
catch (Exception $error) {
    // if the database connection fails, redirect user to error page
    header('location:error.php');
}