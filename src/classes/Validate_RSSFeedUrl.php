<?php

class Validate_RSSFeedUrl extends Validate_Abstract
{

    private $feedUrl;

    public function __construct($feedUrl)
    {
        $this->setFeedUrl($feedUrl);

        parent::__construct();
    }

    public function setFeedUrl($username)
    {
        $this->feedUrl = $username;
    }

    public function getFeedUrl()
    {
        return $this->feedUrl;
    }

    public function validate()
    {
        $feedUrl = $this->getFeedUrl();

        if (empty($feedUrl)) {
            $this->addErrorMessage('RSS feed url field is empty.');
        } elseif (strlen($feedUrl) > 255) {
            $this->addErrorMessage('RSS feed url is too long, 255 characters max.');
        } elseif (!filter_var($feedUrl, FILTER_VALIDATE_URL)) {
            $this->addErrorMessage('RSS feed url is invalid.');
        } else {
            $this->isValid = true;
        }
    }

}
