<?php
$title = 'Hello';
require 'includes/header.php';

try {
    // check for a pageId param
    $pageId = null;

    if (isset($_GET['pageId'])) {
        if (is_numeric($_GET['pageId'])) {
            // if there is a pageId param, store it in a local variable
            $pageId = $_GET['pageId'];

            // connect to database
            require 'includes/db.php';

            // set up query
            $sql = "SELECT pageTitle, pageContent
            FROM pages
            WHERE pageId = :pageId";

            // prepare and execute the query, and fetch the page title and content
            $cmd = $db->prepare($sql);
            $cmd->bindParam(':pageId', $pageId, PDO::PARAM_INT);
            $cmd->execute();
            $page = $cmd->fetch();

            // if the page does not exist in the database, redirect to the error page
            if (empty($page)) {
                $db = null;
                header('location:error.php');
                exit();
            }
            else {
                // if the page does exist in the database, echo the title and content to the screen
                echo
                '<main class="container mt-3">
                    <h1>' . $page['pageTitle'] . '</h1>
                    <p>' . $page['pageContent'] . '</p>
                </main>';
            }

        }
    }

} catch (Exception $error) {
    header('location:error.php');
};