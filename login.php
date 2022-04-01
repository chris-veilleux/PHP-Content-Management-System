<?php
$title = 'Login';
require 'includes/header.php';
?>

<main class="container mt-3 col-md-5">
    <h1>Login</h1>
    <?php
    // check for a url param
    if (!empty($_GET['invalid'])) {
        // if the user has been redirected to the login page with url param invalid=1, show them a generic error message (invalid credentials)
        if ($_GET['invalid'] == 1) {
            echo '<h6 class="alert alert-danger">Your login is invalid. Please try again.</h6>';
        }
        // if the user tried to register an account with a username that already exists, prompt them to log in
        if ($_GET['invalid'] == 2) {
            echo '<h6 class="alert alert-danger">An account with that username already exists. Please log in.</h6>';
        }
    }
    ?>
    <form method="post" action="validate.php">
        <fieldset class="mb-3">
            <label for="username" class="form-label">Email Address</label>
            <input name="username" id="username" class="form-control" required type="email" placeholder="youremail@email.com" />
        </fieldset>
        <fieldset class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" />
        </fieldset>
        <button class="btn btn-primary">Submit</button>
    </form>
</main>