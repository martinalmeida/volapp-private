<?php

declare(strict_types=1);

include(MODELS . 'modelSesion.php');

class Ruta
{
    // --Parametros Privados--
    private $conn;
    private $tableName = "rutas";
    private $viewTable = "view_rutas";
    private $tableRutasContratos = "rutas_contratos";
    private $nit;
    private $idUser;
    private $fechaActual;
    private $idInsert;

    // --Parametros Publicos--
    public $id;
    public $nombre;
    public $origen;
    public $destino;
    public $contrato;
    public $idRuC;
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
            $html .= '<i class="fal fa-info-circle"></i> Rutas</h1>';
            $html .= '<button type="button" class="btn btn-info active" onclick="showModalRegistro();">Agregar <i class="fal fa-plus-square"></i></button>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        } else {

            $html = "";
            $html .= '<h1 class="subheader-title">';
            $html .= '<i class="fal fa-info-circle"></i> Rutas</h1>';
            $html .= '<h3>No tienes permisos de escritura para este modulo.</h3>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        }
    }

    // -- ⊡ Funcion para crear un material ⊡ --
    public function createRuta(): void
    {
        // --Preparamos la consulta--
        $query = "INSERT INTO $this->tableName SET nombre=?, origen=?, destino=?, idUsuario=?, nit=? ;";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->origen = htmlspecialchars(strip_tags($this->origen));
        $this->destino = htmlspecialchars(strip_tags($this->destino));
        $this->idUser = $_SESSION['id'];
        $this->nit = $_SESSION['nit'];

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->nombre);
        $stmt->bindParam(2, $this->origen);
        $stmt->bindParam(3, $this->destino);
        $stmt->bindParam(4, $this->idUser);
        $stmt->bindParam(5, $this->nit);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            $this->idInsert = $this->conn->lastInsertId();
            // --Preparamos la consulta--
            $query = "INSERT INTO $this->tableRutasContratos SET kilometraje=?, tarifa=?, fecha_creado=?, idRuta=?, idContrato =? ;";
            $stmt = $this->conn->prepare($query);

            // --Escapamos los caracteres--
            $this->kilometraje = htmlspecialchars(strip_tags($this->kilometraje));
            $this->tarifa = htmlspecialchars(strip_tags($this->tarifa));
            $this->fechaActual = Utilidades::getFecha();
            $this->contrato = htmlspecialchars(strip_tags($this->contrato));

            // --Almacenamos los valores--
            $stmt->bindParam(1, $this->kilometraje);
            $stmt->bindParam(2, $this->tarifa);
            $stmt->bindParam(3, $this->fechaActual);
            $stmt->bindParam(4, $this->idInsert);
            $stmt->bindParam(5, $this->contrato);

            if ($stmt->execute()) {
                echo json_encode(array('status' => '1', 'data' => NULL));
            }
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para dataTables Serverside ⊡ --
    public function readAllDaTableRutas(): void
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
                            nombre LIKE :nombre OR
                            origen LIKE :origen OR
                            titulo LIKE :titulo OR
                            destino LIKE :destino OR
                            status LIKE :status )";
            $searchArray = array(
                'id' => "%$searchValue%",
                'nombre' => "%$searchValue%",
                'origen' => "%$searchValue%",
                'titulo' => "%$searchValue%",
                'destino' => "%$searchValue%",
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
                $botones .= "<button type='button' class='btn btn-success text-white' data-toggle='tooltip' data-placement='top' title='Editar Material' onclick='editarRegistro(" . $row['id'] . ");'>";
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
                "nombre" => $row['nombre'],
                "origen" => $row['origen'],
                "destino" => $row['destino'],
                "titulo" => $row['titulo'],
                "kilometraje" => $row['kilometraje'],
                "tarifa" => $row['tarifa'],
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
    public function statusRuta(): void
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
    public function dataRuta(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT r.id, r.nombre, r.origen, r.destino, (rc.id)idRuC, rc.kilometraje, rc.tarifa, rc.idContrato FROM $this->tableName r JOIN $this->tableRutasContratos rc ON r.id = rc.idRuta WHERE r.id=? AND rc.status = 1;";
        $stmt = $this->conn->prepare($query);

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->id);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {

            // --Comprobamos que venga algun dato--
            if ($stmt->rowCount() >= 1) {

                // --Cosulta a Objetos--
                $data = $stmt->fetch(PDO::FETCH_OBJ);

                $datos = array(
                    'id' => $data->id,
                    'nombre' => $data->nombre,
                    'origen' => $data->origen,
                    'destino' => $data->destino,
                    'idRuC' => $data->idRuC,
                    'kilometraje' => $data->kilometraje,
                    'tarifa' => $data->tarifa,
                    'contrato' => $data->idContrato,
                );
                // --Retornamos las respuestas--
                echo json_encode(array('status' => '1', 'data' => $datos));
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
    public function updateRuta(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE $this->tableName SET nombre=?, origen=?, destino=?, idUsuario=?, nit=? WHERE id=?";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->origen = htmlspecialchars(strip_tags($this->origen));
        $this->destino = htmlspecialchars(strip_tags($this->destino));
        $this->idUser = $_SESSION['id'];
        $this->nit = $_SESSION['nit'];

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->nombre);
        $stmt->bindParam(2, $this->origen);
        $stmt->bindParam(3, $this->destino);
        $stmt->bindParam(4, $this->idUser);
        $stmt->bindParam(5, $this->nit);
        $stmt->bindParam(6, $this->id);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            // --Preparamos la consulta--
            $query = "UPDATE $this->tableRutasContratos SET status = 3 WHERE id=?";
            $stmt = $this->conn->prepare($query);

            // --Almacenamos los valores--
            $stmt->bindParam(1, $this->idRuC);

            if ($stmt->execute()) {
                // --Preparamos la consulta--
                $query = "INSERT INTO $this->tableRutasContratos SET kilometraje=?, tarifa=?, fecha_creado=?, idRuta=?, idContrato =? ;";
                $stmt = $this->conn->prepare($query);

                // --Escapamos los caracteres--
                $this->kilometraje = htmlspecialchars(strip_tags($this->kilometraje));
                $this->tarifa = htmlspecialchars(strip_tags($this->tarifa));
                $this->fechaActual = Utilidades::getFecha();
                $this->contrato = htmlspecialchars(strip_tags($this->contrato));

                // --Almacenamos los valores--
                $stmt->bindParam(1, $this->kilometraje);
                $stmt->bindParam(2, $this->tarifa);
                $stmt->bindParam(3, $this->fechaActual);
                $stmt->bindParam(4, $this->id);
                $stmt->bindParam(5, $this->contrato);

                if ($stmt->execute()) {
                    echo json_encode(array('status' => '1', 'data' => NULL));
                }
            }
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para eliminar rol ⊡ --
    public function deleteRuta(): void
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
