<?php

class Model_UserRSSFeed
{

    private $userId, $rssFeedId;

    /* @var $db Helper_DB */
    private $db;

    public function __construct($userId, $rssFeedId)
    {
        $this->setUserId($userId);
        $this->setRssFeedId($rssFeedId);

        $this->db = Helper_DB::getConnection();
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setRssFeedId($rssFeedId)
    {
        $this->rssFeedId = $rssFeedId;
    }

    public function getRssFeedId()
    {
        return $this->rssFeedId;
    }

    public function save()
    {
        $dbParams = array(
            'user_id' => $this->getUserId(),
            'rss_feed_id' => $this->getRssFeedId()
        );

        $this->db->insertRecord(ModelQuery_UserRSSFeed::TABLE_NAME, $dbParams);
    }

    public function delete()
    {
        $dbParams = array(
            'user_id' => $this->getUserId(),
            'rss_feed_id' => $this->getRssFeedId()
        );

        $deleteSuccessful = $this->db->deleteRecord(ModelQuery_UserRSSFeed::TABLE_NAME, 'user_id=:user_id AND rss_feed_id=:rss_feed_id', $dbParams);
        if (!$deleteSuccessful) {
            return false;
        }

        $userRssFeeds = ModelQuery_UserRSSFeed::findAllByRssFeedId($this->getRssFeedId());
        if (count($userRssFeeds) === 0) {
            return $this->getRssFeed()->delete();
        }

        return true;
    }

    public function getRssFeed()
    {
        return ModelQuery_RSSFeed::findById($this->getRssFeedId());
    }

}
