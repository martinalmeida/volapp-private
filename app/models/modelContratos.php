<?php

declare(strict_types=1);

include(MODELS . 'modelSesion.php');

class Contrato
{
    // --Parametros Privados--
    private $conn;
    private $tableName = "contratos";
    private $nit;
    private $idUser;

    // --Parametros Publicos--
    public $id;
    public $fechaInicio;
    public $fechaFin;
    public $titulo;
    public $representante;
    public $telefono;
    public $email;
    public $contenType;
    public $base64;
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
            $html .= '<i class="fal fa-info-circle"></i> Contratos</h1>';
            $html .= '<button type="button" class="btn btn-info active" onclick="showModalRegistro();">Agregar <i class="fal fa-plus-square"></i></button>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        } else {

            $html = "";
            $html .= '<h1 class="subheader-title">';
            $html .= '<i class="fal fa-info-circle"></i> Contratos</h1>';
            $html .= '<h3>No tienes permisos de escritura para este modulo.</h3>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        }
    }

    // -- ⊡ Funcion para crear un material ⊡ --
    public function createContrato(): void
    {
        // --Preparamos la consulta--
        $query = "INSERT INTO $this->tableName SET fechaInicio=?, fechaFin=?, titulo=?, representante=?, telefono=?, email=?, content_type=?, base_64=?, idUsuario=?, nit=? ;";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->fechaInicio = htmlspecialchars(strip_tags($this->fechaInicio));
        $this->fechaFin = htmlspecialchars(strip_tags($this->fechaFin));
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->representante = htmlspecialchars(strip_tags($this->representante));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->contenType = htmlspecialchars(strip_tags($this->contenType));
        $this->base64 = htmlspecialchars(strip_tags($this->base64));
        $this->idUser = $_SESSION['id'];
        $this->nit = $_SESSION['nit'];

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->fechaInicio);
        $stmt->bindParam(2, $this->fechaFin);
        $stmt->bindParam(3, $this->titulo);
        $stmt->bindParam(4, $this->representante);
        $stmt->bindParam(5, $this->telefono);
        $stmt->bindParam(6, $this->email);
        $stmt->bindParam(7, $this->contenType);
        $stmt->bindParam(8, $this->base64);
        $stmt->bindParam(9, $this->idUser);
        $stmt->bindParam(10, $this->nit);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para dataTables Serverside ⊡ --
    public function readAllDaTableContrato(): void
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
            $searchQuery = " AND (id LIKE :id OR 
                            fechaInicio LIKE :fechaInicio OR
                            fechaFin LIKE :fechaFin OR
                            titulo LIKE :titulo OR
                            representante LIKE :representante OR
                            telefono LIKE :telefono OR
                            email LIKE :email OR
                            status LIKE :status )";
            $searchArray = array(
                'id' => "%$searchValue%",
                'fechaInicio' => "%$searchValue%",
                'fechaFin' => "%$searchValue%",
                'titulo' => "%$searchValue%",
                'representante' => "%$searchValue%",
                'telefono' => "%$searchValue%",
                'email' => "%$searchValue%",
                'status' => "%$searchValue%"
            );
        }
        // --Total number of records without filtering--
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS allcount FROM " . $this->tableName . " WHERE status = 1");
        $stmt->execute();
        $records = $stmt->fetch();
        $totalRecords = $records['allcount'];
        // --Total number of records with filtering--
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS allcount FROM " . $this->tableName . " WHERE status = 1 AND 1 " . $searchQuery . "");
        $stmt->execute($searchArray);
        $records = $stmt->fetch();
        $totalRecordwithFilter = $records['allcount'];
        // --Fetch records--
        $stmt = $this->conn->prepare("SELECT id, fechaInicio, fechaFin, titulo, representante, telefono, email, status FROM " . $this->tableName . " WHERE 1 " . $searchQuery . " AND status in(1, 2) AND nit =  " . $_SESSION['nit'] . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset ");
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
            if ($datos->r === 1) {
                $botones .= '<button type="button" class="btn btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Ver docuemntación del contrato en PDF" onclick="traerArchivo( ' . $row['id'] . ');">';
                $botones .= '<i class="fal fa-file-pdf"></i></button>';
            }
            if ($datos->u === 1) {
                $botones .= "<button type='button' class='btn btn-success text-white' data-toggle='tooltip' data-placement='top' title='Editar Contrato' onclick='editarRegistro(" . $row['id'] . ");'>";
                $botones .= "<i class='fal fa-edit'></i></button>";
                $botones .= "<button type='button' class='btn btn-" . $statusColor . " text-white' data-toggle='tooltip' data-placement='top' title='Estado del Contrato' onclick='statusRegistro(" . $row['id'] . ", " . $row['status'] . ");'>";
                $botones .= "<i class='fal fa-eye'></i></button>";
            }
            if ($datos->d === 1) {
                $botones .= "<button type='button' class='btn btn-danger text-white' data-toggle='tooltip' data-placement='top' title='Eliminar Contrato' onclick='eliminarRegistro(" . $row['id'] . ");'>";
                $botones .= "<i class='fal fa-trash'></i></button>";
            }
            $botones .= "</div>";

            $data[] = array(
                "id" => $row['id'],
                "fechaInicio" => $row['fechaInicio'],
                "fechaFin" => $row['fechaFin'],
                "titulo" => $row['titulo'],
                "representante" => $row['representante'],
                "telefono" => $row['telefono'],
                "email" => $row['email'],
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

    // -- ⊡ Funcion para traer datos la base 64 del archivo y su content type ⊡ --
    public function traerArchivo(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT (content_type)contenType, (base_64)base64 FROM $this->tableName WHERE id=? ;";
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

    // -- ⊡ Funcion para cambiar el estado del rol ⊡ --
    public function statusContrato(): void
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
    public function dataContrato(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT id, fechaInicio, fechaFin, titulo, representante, telefono, email, (content_type)contenType, (base_64)base64 FROM $this->tableName WHERE id=? ;";
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
    public function updateContrato(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE $this->tableName SET fechaInicio=?, fechaFin=?, titulo=?, representante=?, telefono=?, email=?, content_type=?, base_64=?, idUsuario=?, nit=? WHERE id=? ;";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->fechaInicio = htmlspecialchars(strip_tags($this->fechaInicio));
        $this->fechaFin = htmlspecialchars(strip_tags($this->fechaFin));
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->representante = htmlspecialchars(strip_tags($this->representante));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->contenType = htmlspecialchars(strip_tags($this->contenType));
        $this->base64 = htmlspecialchars(strip_tags($this->base64));
        $this->idUser = $_SESSION['id'];
        $this->nit = $_SESSION['nit'];

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->fechaInicio);
        $stmt->bindParam(2, $this->fechaFin);
        $stmt->bindParam(3, $this->titulo);
        $stmt->bindParam(4, $this->representante);
        $stmt->bindParam(5, $this->telefono);
        $stmt->bindParam(6, $this->email);
        $stmt->bindParam(7, $this->contenType);
        $stmt->bindParam(8, $this->base64);
        $stmt->bindParam(9, $this->idUser);
        $stmt->bindParam(10, $this->nit);
        $stmt->bindParam(11, $this->id);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para eliminar rol ⊡ --
    public function deleteContrato(): void
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
