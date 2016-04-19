<?php

class Model_User
{

    private $username, $password, $id;

    /* @var $db Helper_DB */
    private $db;

    public function __construct($username, $password)
    {
        $this->setUsername($username);
        $this->setPassword($password);

        $this->db = Helper_DB::getConnection();
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    private function hashPassword()
    {
        return password_hash($this->getPassword(), PASSWORD_DEFAULT);
    }

    public function verifyPassword($passwordToVerify)
    {
        return password_verify($passwordToVerify, $this->getPassword());
    }

    public function save()
    {
        $dbParams = array(
            'username' => $this->getUsername(),
            'password' => $this->hashPassword()
        );

        $id = $this->db->insertRecord(ModelQuery_User::TABLE_NAME, $dbParams);
        $this->setId($id);
    }

}
