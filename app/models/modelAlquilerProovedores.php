<?php

declare(strict_types=1);

include(MODELS . 'modelSesion.php');

class AlquilerProovedores
{
    // --Parametros Privados--
    private $conn;
    private $nombreModulo = 'alquilerProovedores';
    private $tableName = "maquinarias_contratos";
    private $viewTable = "view_alquiler";
    private $fechaActual;

    // --Parametros Publicos--
    public $id;
    public $placa;
    public $contrato;
    public $standby;
    public $horaTarifa;
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

        if ($datos->w === 1) {

            $html = "";
            $html .= '<h1 class="subheader-title">';
            $html .= '<i class="fal fa-info-circle"></i> Alquiler para Proovedores</h1>';
            $html .= '<button type="button" class="btn btn-info active" onclick="showModalRegistro();">Agregar <i class="fal fa-plus-square"></i></button>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        } else {

            $html = "";
            $html .= '<h1 class="subheader-title">';
            $html .= '<i class="fal fa-info-circle"></i> Alquiler para Proovedores</h1>';
            $html .= '<h3>No tienes permisos de escritura para este modulo.</h3>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        }
    }

    // -- ⊡ Funcion para crear un material ⊡ --
    public function createAlquiler(): void
    {
        // --Preparamos la consulta--
        $query = "INSERT INTO $this->tableName SET standby=?, horaTarifa=?, idMaquinaria=?, idContrato=?, fecha_creado=? ;";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->standby = htmlspecialchars(strip_tags($this->standby));
        $this->horaTarifa = htmlspecialchars(strip_tags($this->horaTarifa));
        $this->placa = htmlspecialchars(strip_tags($this->placa));
        $this->contrato = htmlspecialchars(strip_tags($this->contrato));
        $this->fechaActual = Utilidades::getFecha();

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->standby);
        $stmt->bindParam(2, $this->horaTarifa);
        $stmt->bindParam(3, $this->placa);
        $stmt->bindParam(4, $this->contrato);
        $stmt->bindParam(5, $this->fechaActual);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para dataTables Serverside ⊡ --
    public function readAllDaTableAlquiler(): void
    {
        $sesion = new Sesion($this->conn);
        $sesion->rol = $_SESSION['rol'];
        $sesion->tabla = $this->nombreModulo;
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
            $searchQuery = " AND (id LIKE :id OR 
                            tipo LIKE :tipo OR
                            placa LIKE :placa OR
                            titulo LIKE :titulo OR
                            standby LIKE :standby OR
                            horaTarifa LIKE :horaTarifa OR
                            status LIKE :status )";
            $searchArray = array(
                'id' => "%$searchValue%",
                'tipo' => "%$searchValue%",
                'placa' => "%$searchValue%",
                'titulo' => "%$searchValue%",
                'standby' => "%$searchValue%",
                'horaTarifa' => "%$searchValue%",
                'status' => "%$searchValue%"
            );
        }
        // --Total number of records without filtering--
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS allcount FROM " . $this->viewTable . " WHERE nit = " . $_SESSION['nit'] . " ");
        $stmt->execute();
        $records = $stmt->fetch();
        $totalRecords = $records['allcount'];
        // --Total number of records with filtering--
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS allcount FROM " . $this->viewTable . " WHERE 1 " . $searchQuery . " AND nit = " . $_SESSION['nit'] . " ");
        $stmt->execute($searchArray);
        $records = $stmt->fetch();
        $totalRecordwithFilter = $records['allcount'];
        // --Fetch records--
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->viewTable . " WHERE 1 " . $searchQuery . " AND status in(1, 2) AND nit = " . $_SESSION['nit'] . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset ");
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
                $botones .= "<button type='button' class='btn btn-success text-white' data-toggle='tooltip' data-placement='top' title='Editar Material' onclick='editarRegistro(" . $row['idMaquinaria'] . ");'>";
                $botones .= "<i class='fal fa-edit'></i></button>";
                $botones .= "<button type='button' class='btn btn-" . $statusColor . " text-white' data-toggle='tooltip' data-placement='top' title='Estado del Material' onclick='statusRegistro(" . $row['id'] . ", " . $row['status'] . ");'>";
                $botones .= "<i class='fal fa-eye'></i></button>";
            }
            if ($datos->d === 1) {
                $botones .= "<button type='button' class='btn btn-danger text-white' data-toggle='tooltip' data-placement='top' title='Eliminar Material' onclick='eliminarRegistro(" . $row['id'] . ");'>";
                $botones .= "<i class='fal fa-trash'></i></button>";
            }
            $botones .= "</div>";

            $data[] = array(
                "id" => $row['id'],
                "tipo" => $row['tipo'],
                "placa" => $row['placa'],
                "titulo" => $row['titulo'],
                "standby" => $row['standby'],
                "horaTarifa" => $row['horaTarifa'],
                "status" => $estado,
                "defaultContent" => "$botones"
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
    public function statusAlquiler(): void
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
    public function dataAlquiler(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT * FROM $this->tableName WHERE idMaquinaria=? AND status = 1;";
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
    public function updateAlquilar(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE $this->tableName SET status=3 WHERE idMaquinaria=?";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            // --Preparamos la consulta--
            $query = "INSERT INTO $this->tableName SET standby=?, horaTarifa=?, idMaquinaria=?, idContrato=?, fecha_creado=? ;";
            $stmt = $this->conn->prepare($query);

            // --Escapamos los caracteres--
            $this->standby = htmlspecialchars(strip_tags($this->standby));
            $this->horaTarifa = htmlspecialchars(strip_tags($this->horaTarifa));
            $this->placa = htmlspecialchars(strip_tags($this->placa));
            $this->contrato = htmlspecialchars(strip_tags($this->contrato));
            $this->fechaActual = Utilidades::getFecha();

            // --Almacenamos los valores--
            $stmt->bindParam(1, $this->standby);
            $stmt->bindParam(2, $this->horaTarifa);
            $stmt->bindParam(3, $this->placa);
            $stmt->bindParam(4, $this->contrato);
            $stmt->bindParam(5, $this->fechaActual);

            if ($stmt->execute()) {
                echo json_encode(array('status' => '1', 'data' => NULL));
            }
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para eliminar rol ⊡ --
    public function deleteAlquiler(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE $this->tableName SET status = 3 WHERE id=?";
        $stmt = $this->conn->prepare($query);

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->id);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }
}
