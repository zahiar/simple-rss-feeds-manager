<?php

require_once 'core/init.php';

$authenticationService = new Service_Authentication();
$authenticationService->logUserOut();

$pageTitle = 'Log out';
$pageContent = '<p>You have now logged out. <br/><a href="index.php">Click here to continue</a></p>';

require_once 'view/main.php';
