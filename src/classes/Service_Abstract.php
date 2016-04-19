<?php

abstract class Service_Abstract
{

    protected $errorMessages;

    public function __construct()
    {
        $this->errorMessages = array();
    }

    public function getErrorMessages()
    {
        return $this->errorMessages;
    }

    public function addErrorMessage($message)
    {
        $this->errorMessages[] = $message;
    }

    public function addErrorMessages($messagesArray)
    {
        $this->errorMessages = array_merge($this->getErrorMessages(), $messagesArray);
    }

}
