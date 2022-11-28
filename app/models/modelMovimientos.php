<?php

declare(strict_types=1);

include(MODELS . 'modelSesion.php');

class Movimientos
{
    // --Parametros Privados--
    private $conn;
    private $tableName = "movimientos";
    private $tableMaquinaria = "maquinarias";
    private $tableTpMaquinaria = "tipo_maquinaria";
    private $tableRutas = "rutas";
    private $tableRutaContrato = "rutas_contratos";
    private $tableContratos = "contratos";
    private $tableUsuarios = "usuarios";
    private $nit;
    private $idUser;

    // --Parametros Publicos--
    public $id;
    public $ruta;
    public $kilometraje;
    public $tarifa;
    public $status;

    /* Propiedades de los objetos de Datatables para utilizar (Serverside) 
    Procesamiento del lado del servidor */
    public $draw;
    public $row;
    public $rowperpage;
    public $columnIndex;
    public $columnName;
    public $columnSortOrder;
    public $searchValue;


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
        $sesion->tabla = $this->tableName;

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
        $sesion->tabla = $this->tableName;

        $datos = $sesion->permisoModulo();

        if ($datos->w === 1) {

            $html = "";
            $html .= '<h1 class="subheader-title">';
            $html .= '<i class="fal fa-info-circle"></i> Movimientos</h1>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        } else {

            $html = "";
            $html .= '<h1 class="subheader-title">';
            $html .= '<i class="fal fa-info-circle"></i> Movimientos</h1>';
            $html .= '<h3>No tienes permisos de escritura para este modulo.</h3>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        }
    }

    // -- ⊡ Funcion para dataTables Serverside ⊡ --
    public function readAllDaTableMovimiento(): void
    {
        $sesion = new Sesion($this->conn);
        $sesion->rol = $_SESSION['rol'];
        $sesion->tabla = $this->tableName;
        $datos = $sesion->permisoModulo();

        // --Read value--
        $draw = $this->draw = htmlspecialchars(strip_tags($this->draw));
        $row = $this->row = htmlspecialchars(strip_tags($this->row));
        $rowperpage = $this->rowperpage = htmlspecialchars(strip_tags($this->rowperpage));
        $columnIndex = $this->columnIndex = htmlspecialchars(strip_tags($this->columnIndex));
        $columnName = $this->columnName = htmlspecialchars(strip_tags($this->columnName));
        $columnSortOrder = $this->columnSortOrder = htmlspecialchars(strip_tags($this->columnSortOrder));
        $searchValue = $this->searchValue = htmlspecialchars(strip_tags($this->searchValue));
        $searchArray = array();
        // --Search--
        $searchQuery = " ";
        if ($searchValue != '') {
            $searchQuery = " AND (mo.id LIKE :id OR 
                            tm.tipo LIKE :tipo OR
                            m.placa LIKE :placa OR
                            c.titulo LIKE :contrato OR
                            r.origen LIKE :ruta OR
                            mo.kilometraje LIKE :kilometraje OR
                            mo.tarifa LIKE :tarifa OR
                            u.nombres LIKE :nombres OR
                            mo.status LIKE :status )";
            $searchArray = array(
                'id' => "%$searchValue%",
                'tipo' => "%$searchValue%",
                'placa' => "%$searchValue%",
                'contrato' => "%$searchValue%",
                'ruta' => "%$searchValue%",
                'kilometraje' => "%$searchValue%",
                'tarifa' => "%$searchValue%",
                'nombres' => "%$searchValue%",
                'status' => "%$searchValue%"
            );
        }
        // --Total number of records without filtering--
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS allcount FROM " . $this->tableName . " mo 
                                      JOIN " . $this->tableMaquinaria . " m ON m.id = mo.idMaquinaria 
                                      JOIN " . $this->tableTpMaquinaria . " tm ON tm.id = m.idTpMaquinaria 
                                      LEFT JOIN " . $this->tableRutas . " r ON mo.idRuta = r.id 
                                      LEFT JOIN " . $this->tableRutaContrato . " rc ON r.id = rc.idRuta 
                                      LEFT JOIN " . $this->tableContratos . " c ON rc.idContrato = c.id
                                      JOIN " . $this->tableUsuarios . " u ON mo.idUsuario = u.id ");
        $stmt->execute();
        $records = $stmt->fetch();
        $totalRecords = $records['allcount'];
        // --Total number of records with filtering--
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS allcount FROM " . $this->tableName . " mo 
                                      JOIN " . $this->tableMaquinaria . " m ON m.id = mo.idMaquinaria 
                                      JOIN " . $this->tableTpMaquinaria . " tm ON tm.id = m.idTpMaquinaria 
                                      LEFT JOIN " . $this->tableRutas . " r ON mo.idRuta = r.id 
                                      LEFT JOIN " . $this->tableRutaContrato . " rc ON r.id = rc.idRuta 
                                      LEFT JOIN " . $this->tableContratos . " c ON rc.idContrato = c.id
                                      JOIN " . $this->tableUsuarios . " u ON mo.idUsuario = u.id WHERE 1 " . $searchQuery . " ");
        $stmt->execute($searchArray);
        $records = $stmt->fetch();
        $totalRecordwithFilter = $records['allcount'];
        // --Fetch records--
        $stmt = $this->conn->prepare("SELECT mo.id, tm.tipo, m.placa, (c.titulo)contrato, concat(r.origen, ' - ', r.destino)ruta , mo.kilometraje, mo.tarifa, u.nombres, mo.status 
                                      FROM " . $this->tableName . " mo 
                                      JOIN " . $this->tableMaquinaria . " m ON m.id = mo.idMaquinaria 
                                      JOIN " . $this->tableTpMaquinaria . " tm ON tm.id = m.idTpMaquinaria 
                                      LEFT JOIN " . $this->tableRutas . " r ON mo.idRuta = r.id 
                                      LEFT JOIN " . $this->tableRutaContrato . " rc ON r.id = rc.idRuta 
                                      LEFT JOIN " . $this->tableContratos . " c ON rc.idContrato = c.id 
                                      JOIN " . $this->tableUsuarios . " u ON mo.idUsuario = u.id WHERE 1 " . $searchQuery . " AND mo.status in(1, 2) AND m.status = 1 ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset ");
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
            $estado = $row['status'] == '1' ? 'Activo' : 'Inactivo';
            $statusColor = $row['status'] == '1' ? 'info' : 'secondary';

            $botones = "<div class='btn-group'>";
            if ($datos->u === 1) {
                $botones .= "<button type='button' class='btn btn-primary text-white' data-toggle='tooltip' data-placement='top' title='Parametrizar maquinaria' onclick='inicializarParametrizacion(" . $row['id'] . ");'>";
                $botones .= "<i class='fal fa-chart-network'></i></button>";
                $botones .= "<button type='button' class='btn btn-" . $statusColor . " text-white' data-toggle='tooltip' data-placement='top' title='Estado de maquinaria' onclick='statusRegistro(" . $row['id'] . ", " . $row['status'] . ");'>";
                $botones .= "<i class='fal fa-eye'></i></button>";
            }
            $botones .= "</div>";

            $data[] = array(
                "id" => $row['id'],
                "tipo" => $row['tipo'],
                "placa" => $row['placa'],
                "contrato" => $row['contrato'],
                "ruta" => $row['ruta'],
                "kilometraje" => $row['kilometraje'],
                "tarifa" => $row['tarifa'],
                "nombres" => $row['nombres'],
                "status" => $estado,
                "defaultContent" => "$botones",
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

    // -- ⊡ Funcion para cambiar el estado del rol ⊡ --
    public function statusMovimiento(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE $this->tableName SET status =? WHERE id=?";
        $stmt = $this->conn->prepare($query);

        $estado = $this->status == '1' ? '2' : '1';

        // --Almacenamos los valores--
        $stmt->bindParam(1, $estado);
        $stmt->bindParam(2, $this->id);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para traer datos del rol ⊡ --
    public function dataMovimiento(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT mo.id, m.placa, tm.tipo, mo.idRuta, mo.kilometraje, mo.tarifa FROM $this->tableName mo JOIN $this->tableMaquinaria m ON m.id = mo.idMaquinaria JOIN $this->tableTpMaquinaria tm ON tm.id = m.idTpMaquinaria WHERE mo.id=? ;";
        $stmt = $this->conn->prepare($query);

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->id);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {

            // --Comprobamos que venga algun dato--
            if ($stmt->rowCount() >= 1) {

                // --Retornamos las respuestas--
                echo json_encode(array('status' => '1', 'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)));
            } else {
                // --Usuario no encontrado o inactivo--
                echo json_encode(array('status' => '3', 'data' => NULL));
            }
        } else {
            // --Falla en la ejecución de la consulta--
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para actualizar empresa ⊡ --
    public function parametrizacionMovimiento(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE $this->tableName SET idRuta=?, kilometraje=?, tarifa=?, dateupdate=?, idUsuario=?, nit=? WHERE id=? ;";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->ruta = htmlspecialchars(strip_tags($this->ruta));
        $this->kilometraje = htmlspecialchars(strip_tags($this->kilometraje));
        $this->tarifa = htmlspecialchars(strip_tags($this->tarifa));
        $this->fechaActual = Utilidades::getFecha();
        $this->idUser = $_SESSION['id'];
        $this->nit = $_SESSION['nit'];

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->ruta);
        $stmt->bindParam(2, $this->kilometraje);
        $stmt->bindParam(3, $this->tarifa);
        $stmt->bindParam(4, $this->fechaActual);
        $stmt->bindParam(5, $this->idUser);
        $stmt->bindParam(6, $this->nit);
        $stmt->bindParam(7, $this->id);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }
}
