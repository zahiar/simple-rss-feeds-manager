<?php

class ModelQuery_RSSFeed
{

    const TABLE_NAME = 'rss_feed';

    public static function findByUrl($url)
    {
        $db = Helper_DB::getConnection();

        $dbParams = array('url' => $url);
        $record = $db->getRecord(self::TABLE_NAME, array('*'), 'url=:url', $dbParams);
        if (!$record instanceof stdClass) {
            return null;
        }

        $rssFeed = new Model_RSSFeed($record->url);
        $rssFeed->setId($record->id);
        return $rssFeed;
    }

    public static function findById($id)
    {
        $db = Helper_DB::getConnection();

        $dbParams = array('id' => $id);
        $record = $db->getRecord(self::TABLE_NAME, array('*'), 'id=:id', $dbParams);
        if (!$record instanceof stdClass) {
            return null;
        }

        $rssFeed = new Model_RSSFeed($record->url);
        $rssFeed->setId($record->id);
        return $rssFeed;
    }

}
