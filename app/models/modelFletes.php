<?php

declare(strict_types=1);

include(MODELS . 'modelSesion.php');

class Fletes
{
    // --Parametros Privados--
    private $conn;
    private $tableName = "fletes";
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
    public $placa;
    public $ruta;
    public $flete;
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
        $html = "";

        if ($datos->w === 1) {

            $html .= '<h1 class="subheader-title">';
            $html .= '<i class="fal fa-info-circle"></i> Fletes</h1>';
            $html .= '<button type="button" class="btn btn-info active" onclick="showModalRegistro();">Agregar Acuerdo<i class="fal fa-plus-square"></i></button>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        } else {

            $html .= '<h1 class="subheader-title">';
            $html .= '<i class="fal fa-info-circle"></i> Fletes</h1>';
            $html .= '<h3>No tienes permisos de escritura para este modulo.</h3>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        }
    }

    // -- ⊡ Funcion para crear un acuerdo ⊡ --
    public function createAcuerdo(): void
    {
        // --Preparamos la consulta--
        $query = "INSERT INTO $this->tableName SET idMaquinaria=?, idRuta=?, flete=?, datecreated=?, idUsuario=?, nit=? ;";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->placa = htmlspecialchars(strip_tags($this->placa));
        $this->ruta = htmlspecialchars(strip_tags($this->ruta));
        $this->flete = htmlspecialchars(strip_tags($this->flete));
        $this->fechaActual = Utilidades::getFecha();
        $this->idUser = $_SESSION['id'];
        $this->nit = $_SESSION['nit'];

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->placa);
        $stmt->bindParam(2, $this->ruta);
        $stmt->bindParam(3, $this->flete);
        $stmt->bindParam(4, $this->fechaActual);
        $stmt->bindParam(5, $this->idUser);
        $stmt->bindParam(6, $this->nit);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para dataTables Serverside ⊡ --
    public function readAllDaTableFletes(): void
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
            $searchQuery = " AND (f.id LIKE :id OR 
                            tm.tipo LIKE :tipo OR
                            m.placa LIKE :placa OR
                            c.titulo LIKE :contrato OR
                            r.origen LIKE :ruta OR
                            f.flete LIKE :flete OR
                            u.nombres LIKE :nombres OR
                            f.status LIKE :status )";
            $searchArray = array(
                'id' => "%$searchValue%",
                'tipo' => "%$searchValue%",
                'placa' => "%$searchValue%",
                'contrato' => "%$searchValue%",
                'ruta' => "%$searchValue%",
                'flete' => "%$searchValue%",
                'nombres' => "%$searchValue%",
                'status' => "%$searchValue%"
            );
        }
        // --Total number of records without filtering--
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS allcount FROM " . $this->tableName . " f 
                                      JOIN " . $this->tableMaquinaria . " m ON m.id = f.idMaquinaria 
                                      JOIN " . $this->tableTpMaquinaria . " tm ON tm.id = m.idTpMaquinaria 
                                      LEFT JOIN " . $this->tableRutas . " r ON f.idRuta = r.id 
                                      LEFT JOIN " . $this->tableRutaContrato . " rc ON r.id = rc.idRuta 
                                      LEFT JOIN " . $this->tableContratos . " c ON rc.idContrato = c.id
                                      JOIN " . $this->tableUsuarios . " u ON f.idUsuario = u.id WHERE f.status = 1");
        $stmt->execute();
        $records = $stmt->fetch();
        $totalRecords = $records['allcount'];
        // --Total number of records with filtering--
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS allcount FROM " . $this->tableName . " f 
                                      JOIN " . $this->tableMaquinaria . " m ON m.id = f.idMaquinaria 
                                      JOIN " . $this->tableTpMaquinaria . " tm ON tm.id = m.idTpMaquinaria 
                                      LEFT JOIN " . $this->tableRutas . " r ON f.idRuta = r.id 
                                      LEFT JOIN " . $this->tableRutaContrato . " rc ON r.id = rc.idRuta 
                                      LEFT JOIN " . $this->tableContratos . " c ON rc.idContrato = c.id
                                      JOIN " . $this->tableUsuarios . " u ON f.idUsuario = u.id WHERE f.status = 1 AND 1 " . $searchQuery . " ");
        $stmt->execute($searchArray);
        $records = $stmt->fetch();
        $totalRecordwithFilter = $records['allcount'];
        // --Fetch records--
        $stmt = $this->conn->prepare("SELECT f.id, tm.tipo, m.placa, (c.titulo)contrato, concat(r.origen, ' - ', r.destino)ruta , f.flete, u.nombres, f.status 
                                      FROM " . $this->tableName . " f 
                                      JOIN " . $this->tableMaquinaria . " m ON m.id = f.idMaquinaria 
                                      JOIN " . $this->tableTpMaquinaria . " tm ON tm.id = m.idTpMaquinaria 
                                      LEFT JOIN " . $this->tableRutas . " r ON f.idRuta = r.id 
                                      LEFT JOIN " . $this->tableRutaContrato . " rc ON r.id = rc.idRuta 
                                      LEFT JOIN " . $this->tableContratos . " c ON rc.idContrato = c.id 
                                      JOIN " . $this->tableUsuarios . " u ON f.idUsuario = u.id WHERE 1 " . $searchQuery . " AND f.status in(1, 2) AND m.status = 1 AND f.nit =  " . $_SESSION['nit'] . " GROUP BY f.id ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset ");
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
                "flete" => $row['flete'],
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
    public function statusFlete(): void
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
    public function dataFletes(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT f.id, m.placa, tm.tipo, f.idRuta, f.flete FROM $this->tableName f JOIN $this->tableMaquinaria m ON m.id = f.idMaquinaria JOIN $this->tableTpMaquinaria tm ON tm.id = m.idTpMaquinaria WHERE f.id=? ;";
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
    public function parametrizacionFlete(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE $this->tableName SET idRuta=?, flete=?, dateupdate=?, idUsuario=?, nit=? WHERE id=? ;";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->ruta = htmlspecialchars(strip_tags($this->ruta));
        $this->flete = htmlspecialchars(strip_tags($this->flete));
        $this->fechaActual = Utilidades::getFecha();
        $this->idUser = $_SESSION['id'];
        $this->nit = $_SESSION['nit'];

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->ruta);
        $stmt->bindParam(2, $this->flete);
        $stmt->bindParam(3, $this->fechaActual);
        $stmt->bindParam(4, $this->idUser);
        $stmt->bindParam(5, $this->nit);
        $stmt->bindParam(6, $this->id);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }
}
