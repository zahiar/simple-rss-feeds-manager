<?php

class Helper_DB
{

    public static $instance = null;
    private $pdo;

    public function __construct()
    {
        $host = Config::getDbHost();
        $name = Config::getDbName();
        $user = Config::getDbUser();
        $password = Config::getDbPassword();

        $this->pdo = new PDO("mysql:host=$host;dbname=$name", $user, $password);
    }

    public static function getConnection()
    {
        if (!self::$instance instanceof Helper_DB) {
            self::$instance = new Helper_DB();
        }

        return self::$instance;
    }

    public function insertRecord($tableName, $dataArray)
    {
        $columns = array_keys($dataArray);
        $columnParams = array_map(function ($item) {
            return ":$item";
        }, $columns);

        $sql = "INSERT INTO $tableName (" . implode(',', $columns) . ') VALUES (' . implode(',', $columnParams) . ')';
        $statement = $this->pdo->prepare($sql);
        $statement->execute($dataArray);

        return $this->pdo->lastInsertId();
    }

    public function deleteRecord($tableName, $whereSqlStatement, $whereDataArray)
    {
        $sql = "DELETE FROM $tableName WHERE $whereSqlStatement";

        $statement = $this->pdo->prepare($sql);
        $statement->execute($whereDataArray);

        return $statement->rowCount() > 0;
    }

    private function prepareSelectSql($tableName, $selectColumnsArray, $whereSqlStatement)
    {
        return 'SELECT ' . implode(',', $selectColumnsArray) . " FROM $tableName WHERE $whereSqlStatement";
    }

    public function getRecord($tableName, $selectColumnsArray, $whereSqlStatement, $whereDataArray)
    {
        $sql = $this->prepareSelectSql($tableName, $selectColumnsArray, $whereSqlStatement) . ' LIMIT 1';

        $statement = $this->pdo->prepare($sql);
        $statement->execute($whereDataArray);

        return $statement->fetchObject();
    }

    public function getRecords($tableName, $selectColumnsArray, $whereSqlStatement, $whereDataArray)
    {
        $sql = $this->prepareSelectSql($tableName, $selectColumnsArray, $whereSqlStatement);

        $statement = $this->pdo->prepare($sql);
        $statement->execute($whereDataArray);

        $objectArray = array();
        while ($row = $statement->fetchObject()) {
            $objectArray[] = $row;
        }

        return $objectArray;
    }

}
