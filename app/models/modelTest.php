<?php

declare(strict_types=1);

class Test
{
    // --Parametros--
    private $conn;
    private $tableName = "inputs";
    public $data;

    // --Constructor para la conexion de la BD--
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // --Collection--
    public function selecTest(): void
    {
        $query = "SELECT * FROM " . $this->tableName . " ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(array());
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row);
    }
}
