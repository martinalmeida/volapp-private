<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../'); 
$dotenv->load();

class Database
{
    //propiedad a devolver
    public $conn;

    public function getConnection()
    {
        include_once __DIR__ . "/volappConfig.php";
        $host = $_ENV['HOST_DB'];
        $dbName = $_ENV['NAME_DB'];
        $userName = $_ENV['USER_DB'];
        $password = $_ENV['PASSWORD_DB'];
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
