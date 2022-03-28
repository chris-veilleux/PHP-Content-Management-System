<?php
$title = 'Login';
require 'includes/header.php';
?>

<main class="container mt-3">
    <h1>Login</h1>
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