<?php

require_once 'core/init.php';

$authenticationService = new Service_Authentication();
if (!$authenticationService->isUserLoggedIn()) {
    header('Location: login.php');
    exit();
}

$rssFeedId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$pageTitle = 'Delete Feed';
$pageContent = '<div class="project-form-container">
    <form method="post">
        <div class="form-group">
            Are you sure you want to delete this feed?
            <input type="hidden" name="rss_feed_id" value="' . $rssFeedId . '">
        </div>
        <button type="submit" class="btn btn-danger">Yes</button>
        <a href="feeds.php" class="btn btn-success">No</a>
    </form></div>';

$postAction = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING);
if (strcasecmp($postAction, 'POST') === 0) {
    $rssFeedId = filter_input(INPUT_POST, 'rss_feed_id', FILTER_VALIDATE_INT);
    $user = $authenticationService->getLoggedInUser();

    $rssFeedService = new Service_RSSFeed();
    $deleteSuccessful = $rssFeedService->deleteRssFeedFromUser($rssFeedId, $user);
    if ($deleteSuccessful) {
        header('Location: feeds.php');
        exit();
    } else {
        foreach ($rssFeedService->getErrorMessages() as $errorMessage) {
            $pageContent .= "<p class=\"bg-danger\">$errorMessage</p>";
        }
    }
}

require_once 'view/main.php';
