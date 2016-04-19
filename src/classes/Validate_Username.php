<?php

class Validate_Username extends Validate_Abstract
{

    private $username;

    public function __construct($username)
    {
        $this->setUsername($username);

        parent::__construct();
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function validate()
    {
        $username = $this->getUsername();

        if (empty($username)) {
            $this->addErrorMessage('Username field is empty.');
        } elseif (strlen($username) > 30 || strlen($username) < 6) {
            $this->addErrorMessage('Username must be between 6 and 30 characters.');
        } elseif (ModelQuery_User::findByUsername($username) instanceof Model_User) {
            $this->addErrorMessage('Username already taken, please use anoher one.');
        } else {
            $this->isValid = true;
        }
    }

}
