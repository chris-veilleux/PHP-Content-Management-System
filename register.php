<?php
$title = 'Register';
require 'includes/header.php';
?>

<main class="container mt-3 col-md-5">
    <h1>Administrator Registration</h1>
    <h6 class="alert alert-warning" id="message">Passwords must be a minimum of 8 characters, including 1 digit, 1 upper-case letter, and 1 lower-case letter.</h6>
    <form method="post" action="save-user.php">
        <?php
        try {
            // variables will be used to store information about existing user, if a url param exists
            $userId = null;
            $username = null;

            // check for a url param
            if (isset($_GET['userId'])) {
                if (is_numeric($_GET['userId'])) {
                    $userId = $_GET['userId'];

                    // if a url param exists, retrieve the info about the user from the database
                    require 'includes/db.php';

                    // fetch the username (but not password, as it cannot be unhashed) of the specified user
                    $sql = "SELECT userId, username
                            FROM cmsusers
                            WHERE userId = :userId";
                    $cmd = $db->prepare($sql);
                    $cmd->bindParam(':userId', $userId, PDO::PARAM_INT);
                    $cmd->execute();
                    $user = $cmd->fetch();

                    // if the record does not exist in the database, disconnect from the database and redirect the user to the error page
                    if (empty($user)) {
                        $db = null;
                        header('location:error.php');
                        exit();
                    }
                    // if the record does exists, save the username and id to local variables and disconnect from the database
                    else {
                        $userId = $user['userId'];
                        $username = $user['username'];
                        $db = null;
                    }
                }
            }

        } catch (Exception $error) {
            // if the database connection fails, redirect user to error page
            header('location:error.php');
        }
        ?>

        <fieldset class="mb-3">
            <label for="username" class="form-label">Email Address</label>
            <input name="username" id="username" class="form-control" required type="email" placeholder="youremail@email.com" value="<?php echo $username; ?>"/>
        </fieldset>
        <fieldset class="mb-3">
            <label for="password" class="form-label">
                <?php
                // Specify if the user is creating a new password for an existing user or a password for a new user
                if (!empty($username)) {
                    echo 'New Password:';
                } else {
                    echo 'Password';
                }
                ?>
            </label>
            <input type="password" name="password" id="password" class="form-control" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" />
        </fieldset>
        <fieldset class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm Password</label>
            <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" />
        </fieldset>
    
        <input type="hidden" name="userId" id="userId" value="<?php echo $userId; ?>" />
        <button class="btn btn-primary" onclick="return comparePasswords()">Save</button>
    </form>
</main>