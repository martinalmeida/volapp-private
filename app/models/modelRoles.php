<?php

declare(strict_types=1);

include(MODELS . 'modelSesion.php');

class Rol
{
    // --Parametros Privados--
    private $conn;
    private $tableName = "rol";
    private $tablePermisos = "permisos";
    private $tableModulo = "modulo";

    // --Parametros Publicos--
    public $id;
    public $nombrerol;
    public $descripcion;
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
            $html .= '<i class="fal fa-info-circle"></i> Roles y Permisos</h1>';
            $html .= '<button type="button" class="btn btn-info active m-1" onclick="showModalRegistro();">Agregar <i class="fal fa-plus-square"></i></button>';
            $html .= '<button type="button" class="btn btn-danger" onclick="resetPermisos();">Reset Permisos <i class="fal fa-window-restore"></i></button>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        } else {

            $html = "";
            $html .= '<h1 class="subheader-title">';
            $html .= '<i class="fal fa-info-circle"></i> Roles y Permisos</h1>';
            $html .= '<h3>No tienes permisos de escritura para este modulo.</h3>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        }
    }


    // -- ⊡ Funcion para resetear todos los permisos a los roles ⊡ --
    public function resetPermisos(): void
    {
        // -- ↓↓ Preparamos la consulta ↓↓ --
        $query = "TRUNCATE TABLE $this->tablePermisos ; ";
        $stmt = $this->conn->prepare($query);

        // -- ↓↓ Ejecutamos la consulta y validamos ejecucion ↓↓ --
        if ($stmt->execute()) {

            // -- ↓↓ Preparamos la consulta ↓↓ --
            $query = "SELECT * FROM $this->tableModulo WHERE status = 1 ; ";
            $stmt = $this->conn->prepare($query);

            if ($stmt->execute()) {

                // -- ↓↓ Comprobamos que venga algun dato ↓↓ --
                if ($stmt->rowCount() >= 1) {
                    // -- ↓↓ Modulos encontrados ↓↓ --
                    $data = $stmt->fetchAll();

                    foreach ($data as $row) {

                        $roles = self::allRoles();
                        foreach ($roles as $rowRol) {
                            $rwud = $rowRol['id'] == '1' ? ',r=1, w=1, u=1, d=1' : ',r=1, w=0, u=0, d=0';
                            $query = "INSERT INTO $this->tablePermisos SET rolid=" . $rowRol['id'] . ", moduloid=" . $row['id'] . $rwud . " ; ";
                            $stmt = $this->conn->prepare($query);
                            $stmt->execute();
                        }
                    }
                    echo json_encode(array('status' => '1', 'data' => NULL));
                } else {
                    // -- ↓↓ Modulos no encontrados ↓↓ --
                    echo json_encode(array('status' => '6', 'data' => NULL));
                    exit;
                }
            } else {
                // -- ↓↓ Falla en la ejecución de la consulta ↓↓ --
                print_r($stmt->errorInfo());
            }
        } else {
            // -- ↓↓ Falla en la ejecución de la consulta ↓↓ --
            print_r($stmt->errorInfo());
        }
    }

    // -- ⊡ Funcion para traer los roles ⊡ --
    private function allRoles()
    {
        // -- ↓↓ Preparamos la consulta ↓↓ --
        $query = "SELECT * FROM $this->tableName ; ";
        $stmt = $this->conn->prepare($query);

        // -- ↓↓ Ejecutamos la consulta y validamos ejecucion ↓↓ --
        if ($stmt->execute()) {

            // -- ↓↓ Comprobamos que venga algun dato ↓↓ --
            if ($stmt->rowCount() >= 1) {
                // -- ↓↓ Submodulos encontrados ↓↓ --
                $data = $stmt->fetchAll();
                return $data;
            } else {
                // -- ↓↓ Submodulos no encontrados ↓↓ --
                echo json_encode(array('status' => '6', 'data' => NULL));
                exit;
            }
        } else {
            // -- ↓↓ Falla en la ejecución de la consulta ↓↓ --
            print_r($stmt->errorInfo());
        }
    }

    // -- ⊡ Funcion para crear un rol ⊡ --
    public function createRol(): void
    {
        // --Preparamos la consulta--
        $query = "INSERT INTO $this->tableName SET nombrerol=?, descripcion	=?";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->nombrerol = htmlspecialchars(strip_tags($this->nombrerol));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->nombrerol);
        $stmt->bindParam(2, $this->descripcion);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para dataTables Serverside ⊡ --
    public function readAllDaTableRol(): void
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
                            nombrerol LIKE :nombrerol OR
                            descripcion LIKE :descripcion OR
                            status LIKE :status )";
            $searchArray = array(
                'id' => "%$searchValue%",
                'nombrerol' => "%$searchValue%",
                'descripcion' => "%$searchValue%",
                'status' => "%$searchValue%"
            );
        }
        // --Total number of records without filtering--
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS allcount FROM " . $this->tableName . "");
        $stmt->execute();
        $records = $stmt->fetch();
        $totalRecords = $records['allcount'];
        // --Total number of records with filtering--
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS allcount FROM " . $this->tableName . " WHERE 1 " . $searchQuery . "");
        $stmt->execute($searchArray);
        $records = $stmt->fetch();
        $totalRecordwithFilter = $records['allcount'];
        // --Fetch records--
        $stmt = $this->conn->prepare("SELECT id, nombrerol, descripcion, status FROM " . $this->tableName . " WHERE 1 " . $searchQuery . " AND status in(1, 2) ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset ");
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
                $botones .= "<button type='button' class='btn btn-success text-white' data-toggle='tooltip' data-placement='top' title='Editar Rol' onclick='editarRegistro(" . $row['id'] . ");'>";
                $botones .= "<i class='fal fa-edit'></i></button>";
                $botones .= "<button type='button' class='btn btn-" . $statusColor . " text-white' data-toggle='tooltip' data-placement='top' title='Estado del Rol' onclick='statusRegistro(" . $row['id'] . ", " . $row['status'] . ");'>";
                $botones .= "<i class='fal fa-eye'></i></button>";
                $botones .= "<button type='button' class='btn btn-warning text-white' data-toggle='tooltip' data-placement='top' title='Permisos a modulos' onclick='modulosPermisos(" . $row['id'] . ");'>";
                $botones .= "<i class='fal fa-key'></i></button>";
            }
            if ($datos->d === 1) {
                $botones .= "<button type='button' class='btn btn-danger text-white' data-toggle='tooltip' data-placement='top' title='Eliminar Rol' onclick='eliminarRegistro(" . $row['id'] . ");'>";
                $botones .= "<i class='fal fa-trash'></i></button>";
            }
            $botones .= "</div>";

            $data[] = array(
                "id" => $row['id'],
                "nombrerol" => $row['nombrerol'],
                "descripcion" => $row['descripcion'],
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
    public function statusRol(): void
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
    public function dataRol(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT id, nombrerol, descripcion FROM $this->tableName WHERE id=? ;";
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
                    'nombrerol' => $data->nombrerol,
                    'descripcion' => $data->descripcion
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
    public function updateRol(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE $this->tableName SET nombrerol=?, descripcion=? WHERE id=?";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->nombrerol = htmlspecialchars(strip_tags($this->nombrerol));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->nombrerol);
        $stmt->bindParam(2, $this->descripcion);
        $stmt->bindParam(3, $this->id);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para eliminar rol ⊡ --
    public function deleteRol(): void
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
