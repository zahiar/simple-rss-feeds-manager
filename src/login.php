<?php

require_once 'core/init.php';

$authenticationService = new Service_Authentication();
if ($authenticationService->isUserLoggedIn()) {
    header('Location: feeds.php');
    exit();
}

$pageTitle = 'Login';
$pageContent = '<p>You need to login before you can proceed. If you don\'t have an account click here to <a href="register.php">register</a>.</p>
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
        <button type="submit" class="btn btn-primary">Login</button>
    </form></div>';

$postAction = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);
if (strcasecmp($postAction, 'POST') === 0) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    $successfulAuth = $authenticationService->processAuthentication($username, $password);
    if ($successfulAuth) {
        header('Location: feeds.php');
        exit();
    } else {
        foreach ($authenticationService->getErrorMessages() as $errorMessage) {
            $pageContent .= "<p class=\"bg-danger\">$errorMessage</p>";
        }
    }
}

require_once 'view/main.php';
