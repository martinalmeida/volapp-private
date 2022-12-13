<?php

declare(strict_types=1);

include(MODELS . 'modelSesion.php');

class InformesRelacion
{
    // --Parametros Privados--
    private $conn;
    private $nombreModulo = "informes";
    private $sqlRelacion;

    public $placa;
    public $contrato;
    public $fechaInicio;
    public $fechaFin;

    // --Constructor para la conexion de la BD--
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // -- ⊡ Funcion para permiso de lectura ⊡ --
    public function getReadPermisos(): void
    {
        $sesion = new Sesion($this->conn);
        $sesion->rol = $_SESSION['rol'];
        $sesion->tabla = $this->nombreModulo;

        $datos = $sesion->permisoModulo();

        if ($datos->r === 1) {
            echo json_encode(array('status' => NULL, 'data' => 1));
        } else {
            echo json_encode(array('status' => NULL, 'data' => 0));
        }
    }

    // -- ⊡ Funcion para traer boton de insertar ⊡ --
    public function getWritePermisos(): void
    {
        $sesion = new Sesion($this->conn);
        $sesion->rol = $_SESSION['rol'];
        $sesion->tabla = $this->nombreModulo;

        $datos = $sesion->permisoModulo();
        $html = "";

        if ($datos->w === 1) {

            $html .= '<h1 class="subheader-title">';
            $html .= '<i class="fal fa-info-circle"></i> Relación por Alquiler</h1>';
            $html .= '<button type="button" class="btn btn-primary active m-1" onClick="history.go(-1); return false;"><i class="fal fa-arrow-left"></i> Regresar</button>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        } else {

            $html .= '<h1 class="subheader-title">';
            $html .= '<i class="fal fa-info-circle"></i> Relación por Alquiler</h1>';
            $html .= '<h3>No tienes permisos de escritura para este modulo </h3>';
            $html .= '<button type="button" class="btn btn-primary active m-1" onClick="history.go(-1); return false;"><i class="fal fa-arrow-left"></i> Regresar</button>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        }
    }

    // -- ⊡ Funcion para dataTables Serverside ⊡ --
    public function tableRelacionAlquiler(): void
    {
        // $this->sqlRelacion = 
        // --Read value--
        $draw = $this->draw = htmlspecialchars(strip_tags($this->draw));
        $row = $this->row = htmlspecialchars(strip_tags($this->row));
        $rowperpage = $this->rowperpage = htmlspecialchars(strip_tags($this->rowperpage));
        $columnIndex = $this->columnIndex = htmlspecialchars(strip_tags($this->columnIndex));
        $columnName = $this->columnName = htmlspecialchars(strip_tags($this->columnName));
        $columnSortOrder = $this->columnSortOrder = htmlspecialchars(strip_tags($this->columnSortOrder));
        $searchArray = array();
        // --Total number of records without filtering--
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS allcount FROM $this->tableName WHERE status = 1");
        $stmt->execute();
        $records = $stmt->fetch();
        $totalRecords = $records['allcount'];
        // --Total number of records with filtering--
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS allcount FROM $this->tableName WHERE status = 1 ");
        $stmt->execute($searchArray);
        $records = $stmt->fetch();
        $totalRecordwithFilter = $records['allcount'];
        // --Fetch records--
        $stmt = $this->conn->prepare("SELECT nit, digito, nombre, representante, telefono, direccion, correo, pais, ciudad, contacto, email_tec, email_logis, status FROM " . $this->tableName . " WHERE status in(1, 2) ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset ");
        // --Bind values--
        foreach ($searchArray as $key => $search) {
            $stmt->bindValue(':' . $key, $search, PDO::PARAM_STR);
        }
        $stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
        $stmt->execute();
        $empRecords = $stmt->fetchAll();
        $data = array();
        foreach ($empRecords as $row) {

            $data[] = array(
                "nit" => $row['nit'],
                "digito" => $row['digito'],
                "nombre" => $row['nombre'],
                "representante" => $row['representante'],
                "telefono" => $row['telefono'],
                "direccion" => $row['direccion'],
                "correo" => $row['correo'],
                "pais" => $row['pais'],
                "ciudad" => $row['ciudad'],
                "contacto" => $row['contacto'],
                "emailTec" => $row['email_tec'],
                "emaiLogis" => $row['email_logis']
            );
        }
        // --Response--
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );
        echo json_encode($response);
    }
}
