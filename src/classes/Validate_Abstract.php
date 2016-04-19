<?php

abstract class Validate_Abstract implements Validate_Interface
{

    protected $isValid, $errorMessages;

    public function __construct()
    {
        $this->errorMessages = array();
        $this->isValid = false;
    }

    public function getIsValid()
    {
        return $this->isValid;
    }

    public function getErrorMessages()
    {
        return $this->errorMessages;
    }

    public function addErrorMessage($message)
    {
        $this->errorMessages[] = $message;
    }

}
