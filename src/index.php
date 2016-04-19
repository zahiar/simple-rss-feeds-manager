<?php

require_once 'core/init.php';

$authenticationService = new Service_Authentication();
if ($authenticationService->isUserLoggedIn()) {
    header('Location: feeds.php');
    exit();
}

$pageTitle = 'Welcome';
$pageContent = '<p>Welcome to Simple RSS Feeds Manager.</p>
    <p>To continue, please either login or register if you don\'t have an account.</p>
    <p>
        <a class="btn btn-primary" href="login.php">Log in</a>
        <a class="btn btn-success" href="register.php">Register</a>
    </p>';


require_once 'view/main.php';
