<?php

class ModelQuery_User
{

    const TABLE_NAME = 'user';

    public static function findByUsername($username)
    {
        $db = Helper_DB::getConnection();

        $dbParams = array(
            'username' => $username
        );
        $record = $db->getRecord(self::TABLE_NAME, array('*'), 'username=:username', $dbParams);
        if (!$record instanceof stdClass) {
            return null;
        }

        $user = new Model_User($record->username, $record->password);
        $user->setId($record->id);
        return $user;
    }

    public static function findById($id)
    {
        $db = Helper_DB::getConnection();

        $dbParams = array('id' => $id);
        $record = $db->getRecord(self::TABLE_NAME, array('*'), 'id=:id', $dbParams);
        if (!$record instanceof stdClass) {
            return null;
        }

        $user = new Model_User($record->username, $record->password);
        $user->setId($record->id);
        return $user;
    }

}
