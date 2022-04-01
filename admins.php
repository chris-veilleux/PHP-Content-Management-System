<?php
require 'includes/auth.php';
$title = 'Administrators';
require 'includes/header.php';
?>

<main class="container mt-3 col-lg-9">
    <h1>Administrators</h1>
    <table class="table table-hover mt-2">
        <thead>
            <tr>
                <th>Username</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // check for a url param
            if (!empty($_GET['message'])) {
                // if the user has tried to change an admin username to an already taken username, inform them
                if ($_GET['message'] == 1) {
                    echo '<h6 class="alert alert-danger">That username is already taken. Please try again.</h6>';
                }
                if ($_GET['message'] == 2) {
                    echo '<h6 class="alert alert-success">User information updated.</h6>';
                }
            }

            try {
                // connect to the database
                require 'includes/db.php';

                // set up and run query for retrieving list of admins from the database
                $sql = "SELECT userId, username
                        FROM cmsusers";
                $cmd = $db->prepare($sql);
                $cmd->execute();
                $users = $cmd->fetchAll();

                // iterate over the return data and write it to the table, with buttons to edit or delete for each record
                foreach ($users as $user) {
                    echo '
                    <tr>
                        <td>' . $user['username'] . '</td>
                        <td>
                            <a class="btn btn-outline-primary btn-sm" href="register.php?userId=' . $user['userId'] . '">Edit</a>
                            <a class="btn btn-outline-danger btn-sm" onclick="return confirmDelete()" href="delete-user.php?userId=' . $user['userId'] . '">Delete</a>
                        </td>
                    </tr>
                    ';
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