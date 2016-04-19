<?php

class Config
{

    private static $dbHost = 'localhost';
    private static $dbName = 'project';
    private static $dbUser = 'root';
    private static $dbPassword = 'root';

    public static function getDbHost()
    {
        return self::$dbHost;
    }

    public static function getDbName()
    {
        return self::$dbName;
    }

    public static function getDbUser()
    {
        return self::$dbUser;
    }

    public static function getDbPassword()
    {
        return self::$dbPassword;
    }

}
