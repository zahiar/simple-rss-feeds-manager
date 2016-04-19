<?php

require_once 'core/init.php';

$authenticationService = new Service_Authentication();
if (!$authenticationService->isUserLoggedIn()) {
    header('Location: login.php');
    exit();
}

$pageTitle = 'View Feed';
$pageContent = '<p><a href="feeds.php" class="btn btn-info">Go back</a></p>';

$user = $authenticationService->getLoggedInUser();
$rssFeedId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$rssFeedService = new Service_RSSFeed();
$feed = $rssFeedService->loadRssFeed($rssFeedId, $user);
if (!$feed instanceof SimplePie) {
    foreach ($rssFeedService->getErrorMessages() as $errorMessage) {
        $pageContent .= "<p class=\"bg-danger\">$errorMessage</p>";
    }
} else {
    $pageContent .= '<div class="header">
        <h1><a href="' . $feed->get_permalink() . '" target="_blank">' . $feed->get_title() . '</a></h1>
        <p>' . $feed->get_description() . '</p>
    </div>';

    foreach ($feed->get_items() as $item) {
        $pageContent .= '<div class="item">
            <h2><a href="' . $item->get_permalink() . '" target="_blank">' . $item->get_title() . '</a></h2>
            <p>' . $item->get_description() . '</p>
            <p><small>Posted on ' . $item->get_date('j F Y | g:i a') . '</small></p>
        </div>';
    }
}

require_once 'view/main.php';
