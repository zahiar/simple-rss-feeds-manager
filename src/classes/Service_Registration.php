<?php

class Service_Registration extends Service_Abstract
{

    public function __construct()
    {
        parent::__construct();
    }

    public function processRegistration($username, $password, $passwordConf)
    {
        $usernameValidator = new Validate_Username($username);
        $usernameValidator->validate();
        if (!$usernameValidator->getIsValid()) {
            $this->addErrorMessages($usernameValidator->getErrorMessages());
            return false;
        }

        $passwordValidator = new Validate_Password($password);
        $passwordValidator->validate();
        if (!$passwordValidator->getIsValid()) {
            $this->addErrorMessages($passwordValidator->getErrorMessages());
            return false;
        }

        if (strcmp($password, $passwordConf) !== 0) {
            $this->addErrorMessage('Both passwords must be the same.');
            return false;
        }

        try {
            $newUser = new Model_User($username, $password);
            $newUser->save();
        } catch (PDOException $ex) {
            $this->addErrorMessage('Something went wrong, please try again.');
            return false;
        }

        return true;
    }

}
