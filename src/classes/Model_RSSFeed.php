<?php

class Model_RSSFeed
{

    private $url, $id;

    /* @var $db Helper_DB */
    private $db;

    public function __construct($url)
    {
        $this->setUrl($url);

        $this->db = Helper_DB::getConnection();
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function delete()
    {
        $dbParams = array(
            'id' => $this->getId()
        );

        return $this->db->deleteRecord(ModelQuery_RSSFeed::TABLE_NAME, 'id=:id', $dbParams);
    }

    public function save()
    {
        $dbParams = array(
            'url' => $this->getUrl()
        );

        $id = $this->db->insertRecord(ModelQuery_RSSFeed::TABLE_NAME, $dbParams);
        $this->setId($id);
    }

}
