<?php
require 'includes/auth.php';
$title = 'Pages';
require 'includes/header.php';
?>

<main class="container mt-3">
    <h1>Pages</h1>
    <a href="page-info.php">Add a new page</a>
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                // connect to the database
                require 'includes/db.php';

                // set up and run query for retrieving list of pages from the database
                $sql = "SELECT pageTitle, pageId
                        FROM pages";
                $cmd = $db->prepare($sql);
                $cmd->execute();
                $pages = $cmd->fetchAll();

                // iterate over the returned data and write it to the table, with buttons to edit or delete for each
                foreach ($pages as $page) {
                    echo '
                    <tr>
                        <td>' . $page['pageTitle'] . '</td>
                        <td>
                            <a class="btn btn-outline-primary btn-sm" href="page-info.php?pageId=' . $page['pageId'] . '">Edit</a>
                            <a class="btn btn-outline-danger btn-sm" onclick="return confirmDelete()" href="delete-page.php?pageId=' . $page['pageId'] . '">Delete</a>
                        </td>
                    </tr>';
                }

                // disconnect from the database
                $db = null;


            } catch (Exception $error) {
                // if the database connection fails, redirect to the error page
                header('location:error.php');
            }
            ?>
        </tbody>
    </table>
</main>