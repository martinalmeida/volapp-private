<?php
class Database
{
    //propiedad a devolver
    public $conn;

    public function getConnection()
    {
        include_once __DIR__ . "/vlappConfig.php";
        $host = HOST_DB;
        $dbName = NAME_DB;
        $userName = USER_DB;
        $password = PASSWORD_DB;
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $host . ";dbname=" . $dbName, $userName, $password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
