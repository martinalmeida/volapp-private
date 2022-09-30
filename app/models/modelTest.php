<!-- ========== Start STATUS ========== 
     status->0 == Fallo la consulta
     status->1 == Exito en la consulta
     status->2 == Error de validacion
     status->3 == Archivos falta
     ========== End STATUS ========== -->
<?php
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
    function selecTest()
    {
        $query = "SELECT * FROM " . $this->tableName . " ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(array());
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($row);
        return $row;
    }
}
