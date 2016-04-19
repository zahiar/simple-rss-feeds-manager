<?php

class Service_RSSFeed extends Service_Abstract
{

    public function __construct()
    {
        parent::__construct();
    }

    public function addRssFeedToUser($feedUrl, Model_User $user)
    {
        $feedUrlValidator = new Validate_RSSFeedUrl($feedUrl);
        $feedUrlValidator->validate();
        if (!$feedUrlValidator->getIsValid()) {
            $this->addErrorMessages($feedUrlValidator->getErrorMessages());
            return false;
        }

        try {
            $rssFeed = ModelQuery_RSSFeed::findByUrl($feedUrl);
            if (!$rssFeed instanceof Model_RSSFeed) {
                $rssFeed = new Model_RSSFeed($feedUrl);
                $rssFeed->save();
            }

            $userRssFeed = ModelQuery_UserRSSFeed::findByUserIdAndRssFeedId($user->getId(), $rssFeed->getId());
            if ($userRssFeed instanceof Model_UserRSSFeed) {
                $this->addErrorMessage('You have already added this feed.');
                return false;
            }

            $userRssFeed = new Model_UserRSSFeed($user->getId(), $rssFeed->getId());
            $userRssFeed->save();
        } catch (PDOException $ex) {
            $this->addErrorMessage('Something went wrong, please try again.');
            return false;
        }

        return true;
    }

    public function deleteRssFeedFromUser($rssFeedId, Model_User $user)
    {
        $userRssFeed = ModelQuery_UserRSSFeed::findByUserIdAndRssFeedId($user->getId(), $rssFeedId);
        if (!$userRssFeed instanceof Model_UserRSSFeed) {
            $this->addErrorMessage('You do not have permission to delete this.');
            return false;
        }

        try {
            $deleteSuccessful = $userRssFeed->delete();
            if (!$deleteSuccessful) {
                $this->addErrorMessage('Something went wrong, please try again.');
                return false;
            }
        } catch (PDOException $ex) {
            $this->addErrorMessage('Something went wrong, please try again.');
            return false;
        }

        return true;
    }

    public function loadRssFeed($rssFeedId, Model_User $user)
    {
        $userRssFeed = ModelQuery_UserRSSFeed::findByUserIdAndRssFeedId($user->getId(), $rssFeedId);
        if (!$userRssFeed instanceof Model_UserRSSFeed) {
            $this->addErrorMessage('RSS feed does not exist.');
            return false;
        }

        $rssFeed = $userRssFeed->getRssFeed();
        $feed = new SimplePie();
        $feed->set_feed_url($rssFeed->getUrl());
        $feed->enable_cache(false);
        $feed->force_feed(true);
        $feed->init();
        $feed->handle_content_type();

        if ($feed->error()) {
            $this->addErrorMessage('We were unable to load this feed, please try again later.');
            return false;
        }

        return $feed;
    }

}
