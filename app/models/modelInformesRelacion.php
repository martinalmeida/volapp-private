<?php

declare(strict_types=1);

include(MODELS . 'modelSesion.php');

class InformesRelacion
{
    // --Parametros Privados--
    private $conn;
    private $nombreModulo = "informes";
    private $tableRegisAlquiler = "registros_alquiler";
    private $tableMaquinarias = "maquinarias";
    private $tableMaqContratos = "maquinarias_contratos";
    private $tableContratos = "contratos";
    private $tableDedAlquiler = "deducibles_alquiler";

    public $placa;
    public $contrato;
    public $fechaInicio;
    public $fechaFin;

    /* Propiedades de los objetos de Datatables para utilizar (Serverside) 
    Procesamiento del lado del servidor */
    public $draw;
    public $row;
    public $rowperpage;
    public $columnIndex;
    public $columnName;
    public $columnSortOrder;

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
        $sqlRelacion = "";
        $this->placa != NULL ? $sqlRelacion .= " AND ra.idMaquinaria = $this->placa " : $sqlRelacion .= "";
        $this->contrato != NULL ? $sqlRelacion .= " AND c.id = $this->contrato " : $sqlRelacion .= "";
        $this->fechaInicio != NULL ? $sqlRelacion .= " AND STR_TO_DATE(ra.fechaInicio, '%m/%d/%Y') >= STR_TO_DATE('$this->fechaInicio', '%m/%d/%Y') " : $sqlRelacion .= "";
        $this->fechaFin != NULL ? $sqlRelacion .= " AND STR_TO_DATE(ra.fechaFin, '%m/%d/%Y') <= STR_TO_DATE('$this->fechaFin', '%m/%d/%Y') " : $sqlRelacion .= "";
        // --Read value--
        echo $sqlRelacion;
        exit;
        $draw = $this->draw = htmlspecialchars(strip_tags($this->draw));
        $row = $this->row = htmlspecialchars(strip_tags($this->row));
        $rowperpage = $this->rowperpage = htmlspecialchars(strip_tags($this->rowperpage));
        $columnIndex = $this->columnIndex = htmlspecialchars(strip_tags($this->columnIndex));
        $columnName = $this->columnName = htmlspecialchars(strip_tags($this->columnName));
        $columnSortOrder = $this->columnSortOrder = htmlspecialchars(strip_tags($this->columnSortOrder));
        $searchArray = array();
        // --Total number of records without filtering--
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS allcount FROM $this->tableRegisAlquiler WHERE status = 1");
        $stmt->execute();
        $records = $stmt->fetch();
        $totalRecords = $records['allcount'];
        // --Total number of records with filtering--
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS allcount FROM $this->tableRegisAlquiler WHERE status = 1 ");
        $stmt->execute($searchArray);
        $records = $stmt->fetch();
        $totalRecordwithFilter = $records['allcount'];
        // --Fetch records--
        $stmt = $this->conn->prepare("SELECT
                                      ra.id,
                                      m.placa,
                                      ra.fechaInicio,
                                      ra.fechaFin,
                                      c.titulo ,
                                      ra.horometroInicial,
                                      ra.horometroFin,
                                      (ra.horometroFin - ra.horometroInicial)totalHoras,
                                      mc.standby,
                                      mc.horaTarifa,
                                      ((ra.horometroFin - ra.horometroInicial) * mc.horaTarifa)subTotal,
                                      da.anticipo,
                                      da.otros,
                                      (((ra.horometroFin - ra.horometroInicial) * (mc.horaTarifa)) - (IFNULL(da.anticipo,0) + IFNULL(da.otros,0)))total 
                                      FROM $this->tableRegisAlquiler ra 
                                      JOIN $this->tableMaquinarias m on ra.idMaquinaria = m.id 
                                      JOIN $this->tableMaqContratos mc on mc.idMaquinaria = m.id 
                                      JOIN $this->tableContratos c on mc.idContrato = c.id 
                                      LEFT JOIN $this->tableDedAlquiler da on da.idRegistro = ra.id 
                                      WHERE ra.status = 1 AND mc.status = 1 $sqlRelacion GROUP BY ra.id ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset ");
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
                "id" => $row['id'],
                "placa" => $row['placa'],
                "fechaInicio" => $row['fechaInicio'],
                "fechaFin" => $row['fechaFin'],
                "titulo" => $row['titulo'],
                "horometroInicial" => $row['horometroInicial'],
                "horometroFin" => $row['horometroFin'],
                "totalHoras" => $row['totalHoras'],
                "standby" => $row['standby'],
                "horaTarifa" => $row['horaTarifa'],
                "subTotal" => $row['subTotal'],
                "anticipo" => $row['anticipo'],
                "otros" => $row['otros'],
                "total" => $row['total']
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
