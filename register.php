<?php
$title = 'Register';
require 'includes/header.php';
?>

<main class="container mt-3">
    <h1>Register As Administrator</h1>
    <form method="post" action="save-user.php">
        <fieldset class="mb-3">
            <label for="username" class="form-label">Email Address</label>
            <input name="username" id="username" class="form-control" required type="email" placeholder="youremail@email.com" />
        </fieldset>
        <fieldset class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" />
        </fieldset>
        <fieldset class="mb-3">
            <label for="confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="confirm" id="confirm" class="form-control" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" />
        </fieldset>
        <button class="btn btn-primary" onclick="return comparePasswords()">Register</button>
    </form>
</main>