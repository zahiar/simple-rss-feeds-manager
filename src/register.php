<?php

require_once 'core/init.php';

$authenticationService = new Service_Authentication();
if ($authenticationService->isUserLoggedIn()) {
    header('Location: feeds.php');
    exit();
}

$pageTitle = 'Register';
$pageContent = '<p>If you already have an account, click here to <a href="login.php">login</a>.</p>
    <div class="project-form-container">
    <form method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
        </div>
        <div class="form-group">
            <label for="password_conf">Confirm your password</label>
            <input type="password" class="form-control" id="password_conf" name="password_conf" placeholder="Confirm your password">
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form></div>';

$postAction = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);
if (strcasecmp($postAction, 'POST') === 0) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $passwordConf = filter_input(INPUT_POST, 'password_conf', FILTER_SANITIZE_STRING);

    $registrationService = new Service_Registration();
    $registerSuccessful = $registrationService->processRegistration($username, $password, $passwordConf);
    if ($registerSuccessful) {
        $pageContent .= '<p class="bg-success">You have successfully registered. 
            <a href="login.php">Click here to log in.</a></p>';
    } else {
        foreach ($registrationService->getErrorMessages() as $errorMessage) {
            $pageContent .= "<p class=\"bg-danger\">$errorMessage</p>";
        }
    }
}

require_once 'view/main.php';
