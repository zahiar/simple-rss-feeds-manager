<?php

require_once 'core/init.php';

$authenticationService = new Service_Authentication();
if (!$authenticationService->isUserLoggedIn()) {
    header('Location: login.php');
    exit();
}

$pageTitle = 'Add New Feed';
$pageContent = '<div class="project-form-container">
    <form method="post">
        <div class="form-group">
            <label for="url">RSS feed url</label>
            <input type="text" class="form-control" id="url" name="url" placeholder="Enter RSS feed url">
        </div>
        <button type="submit" class="btn btn-success">Add feed</button>
        <a href="feeds.php" class="btn btn-info">Go back</a>
    </form></div>';

$postAction = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);
if (strcasecmp($postAction, 'POST') === 0) {
    $feedUrl = filter_input(INPUT_POST, 'url');
    $user = $authenticationService->getLoggedInUser();

    $rssFeedService = new Service_RSSFeed();
    $addSuccessful = $rssFeedService->addRssFeedToUser($feedUrl, $user);
    if ($addSuccessful) {
        $pageContent .= '<p class="bg-success">RSS feed added successfully.';
    } else {
        foreach ($rssFeedService->getErrorMessages() as $errorMessage) {
            $pageContent .= "<p class=\"bg-danger\">$errorMessage</p>";
        }
    }
}

require_once 'view/main.php';
