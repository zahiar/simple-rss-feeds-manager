<?php

class Service_Authentication extends Service_Abstract
{

    public function __construct()
    {
        parent::__construct();
    }

    public function processAuthentication($username, $password)
    {
        if (empty($username)) {
            $this->addErrorMessage('Username field is empty.');
        } elseif (empty($password)) {
            $this->addErrorMessage('Password field is empty.');
        } else {
            $user = ModelQuery_User::findByUsername($username);
            if ($user instanceof Model_User && $user->verifyPassword($password)) {
                session_regenerate_id();
                $_SESSION['user_id'] = $user->getId();

                return true;
            }

            $this->addErrorMessage('Invalid login credentials.');
        }

        return false;
    }

    public function getLoggedInUser()
    {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        $user_id = filter_var($_SESSION['user_id'], FILTER_VALIDATE_INT);
        if (!$user_id) {
            return null;
        }

        return ModelQuery_User::findById($user_id);
    }

    public function isUserLoggedIn()
    {
        if ($this->getLoggedInUser() instanceof Model_User) {
            return true;
        }

        return false;
    }

    public function logUserOut()
    {
        session_destroy();
    }

}
