<?php

class ModelQuery_UserRSSFeed
{

    const TABLE_NAME = 'user_rss_feed';

    public static function findAllByUserId($userId)
    {
        $db = Helper_DB::getConnection();

        $dbParams = array('user_id' => $userId);
        $records = $db->getRecords(self::TABLE_NAME, array('*'), 'user_id=:user_id', $dbParams);

        $rssFeedObjectsArray = array();
        foreach ($records as $record) {
            $rssFeedObjectsArray[] = ModelQuery_RSSFeed::findById($record->rss_feed_id);
        }

        return $rssFeedObjectsArray;
    }

    public static function findAllByRssFeedId($rssFeedId)
    {
        $db = Helper_DB::getConnection();

        $dbParams = array('rss_feed_id' => $rssFeedId);
        $records = $db->getRecords(self::TABLE_NAME, array('*'), 'rss_feed_id=:rss_feed_id', $dbParams);

        $rssFeedObjectsArray = array();
        foreach ($records as $record) {
            $rssFeedObjectsArray[] = ModelQuery_RSSFeed::findById($record->rss_feed_id);
        }

        return $rssFeedObjectsArray;
    }

    public static function findByUserIdAndRssFeedId($userId, $rssFeedId)
    {
        $db = Helper_DB::getConnection();

        $dbParams = array(
            'user_id' => $userId,
            'rss_feed_id' => $rssFeedId
        );
        $record = $db->getRecord(self::TABLE_NAME, array('*'), 'user_id=:user_id AND rss_feed_id=:rss_feed_id', $dbParams);
        if (!$record instanceof stdClass) {
            return null;
        }

        return new Model_UserRSSFeed($record->user_id, $record->rss_feed_id);
    }

}
