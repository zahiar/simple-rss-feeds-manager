<?php

class Validate_Password extends Validate_Abstract
{

    private $password;

    public function __construct($password)
    {
        $this->setPassword($password);

        parent::__construct();
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function validate()
    {
        $password = $this->getPassword();

        if (empty($password)) {
            $this->addErrorMessage('Password field is empty.');
        } elseif (strlen($password) > 30 || strlen($password) < 6) {
            $this->addErrorMessage('Password must be between 6 and 30 characters.');
        } else {
            $this->isValid = true;
        }
    }

}
