<?php

require_once 'core/init.php';

$authenticationService = new Service_Authentication();
if (!$authenticationService->isUserLoggedIn()) {
    header('Location: login.php');
    exit();
}

$pageTitle = 'RSS Feeds';
$pageContent = '<a class="btn btn-success" href="feed_add.php">Add new feed</a>';

$user = $authenticationService->getLoggedInUser();
$userRssFeeds = ModelQuery_UserRSSFeed::findAllByUserId($user->getId());

$pageContent .= '<table class="table table-hover">
    <thead>
        <tr>
            <th>RSS Feed</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>';
foreach ($userRssFeeds as $rssFeed) {
    /* @var $rssFeed Model_RSSFeed */

    $pageContent .= '<tr>
        <td>' . htmlentities($rssFeed->getUrl()) . '</td>
        <td>
            <a class="btn btn-primary" href="feed_view.php?id=' . $rssFeed->getId() . '">View feed</a>
            <a class="btn btn-danger" href="feed_delete.php?id=' . $rssFeed->getId() . '">Delete feed</a>
        </td>
    </tr>';
}
$pageContent .= '</tbody></table>';

require_once 'view/main.php';
