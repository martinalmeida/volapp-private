<?php

declare(strict_types=1);

include(MODELS . 'modelSesion.php');

class Empresa
{
    // --Parametros Privados--
    private $conn;
    private $tableName = "empresas";

    // --Parametros Publicos--
    public $nit;
    public $digito;
    public $nombre;
    public $representante;
    public $telefono;
    public $direccion;
    public $correo;
    public $pais;
    public $ciudad;
    public $contacto;
    public $emailTec;
    public $emailLogis;
    public $contenType;
    public $base64;
    public $status;
    public $id;

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
            $html .= '<i class="fal fa-info-circle"></i> Empresas</h1>';
            $html .= '<button type="button" class="btn btn-info active" onclick="showModalRegistro();">Agregar <i class="fal fa-plus-square"></i></button>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        } else {

            $html = "";
            $html .= '<h1 class="subheader-title">';
            $html .= '<i class="fal fa-info-circle"></i> Empresas</h1>';
            $html .= '<h3>No tienes permisos de escritura para este modulo.</h3>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        }
    }

    // -- ⊡ Funcion para crear una empresa ⊡ --
    public function createEmpresa(): void
    {
        // --Preparamos la consulta--
        $query = "INSERT INTO $this->tableName SET nit=?, digito=?, nombre=?, representante=?, telefono=?, direccion=?, correo=?,
        contacto=?, email_tec=?, email_logis=?, content_type=?, base_64=?";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->nit = htmlspecialchars(strip_tags($this->nit));
        $this->digito = htmlspecialchars(strip_tags($this->digito));
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->representante = htmlspecialchars(strip_tags($this->representante));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        $this->contacto = htmlspecialchars(strip_tags($this->contacto));
        $this->emailTec = htmlspecialchars(strip_tags($this->emailTec));
        $this->emailLogis = htmlspecialchars(strip_tags($this->emailLogis));
        $this->contenType = htmlspecialchars(strip_tags($this->contenType));
        $this->base64 = htmlspecialchars(strip_tags($this->base64));

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->nit);
        $stmt->bindParam(2, $this->digito);
        $stmt->bindParam(3, $this->nombre);
        $stmt->bindParam(4, $this->representante);
        $stmt->bindParam(5, $this->telefono);
        $stmt->bindParam(6, $this->direccion);
        $stmt->bindParam(7, $this->correo);
        $stmt->bindParam(8, $this->contacto);
        $stmt->bindParam(9, $this->emailTec);
        $stmt->bindParam(10, $this->emailLogis);
        $stmt->bindParam(11, $this->contenType);
        $stmt->bindParam(12, $this->base64);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para dataTables Serverside ⊡ --
    public function readAllDaTableEmpresa(): void
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
            $searchQuery = " AND (nit LIKE :nit OR 
                            digito LIKE :digito OR
                            nombre LIKE :nombre OR
                            representante LIKE :representante OR 
                            telefono LIKE :telefono OR
                            direccion LIKE :direccion OR
                            correo LIKE :correo OR
                            pais LIKE :pais OR
                            ciudad LIKE :ciudad OR
                            contacto LIKE :contacto OR
                            email_tec LIKE :email_tec OR
                            email_logis LIKE :email_logis OR
                            status LIKE :status )";
            $searchArray = array(
                'nit' => "%$searchValue%",
                'digito' => "%$searchValue%",
                'nombre' => "%$searchValue%",
                'representante' => "%$searchValue%",
                'telefono' => "%$searchValue%",
                'direccion' => "%$searchValue%",
                'correo' => "%$searchValue%",
                'pais' => "%$searchValue%",
                'ciudad' => "%$searchValue%",
                'contacto' => "%$searchValue%",
                'email_tec' => "%$searchValue%",
                'email_logis' => "%$searchValue%",
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
        $stmt = $this->conn->prepare("SELECT nit, digito, nombre, representante, telefono, direccion, correo, pais, ciudad, contacto, email_tec, email_logis, status FROM " . $this->tableName . " WHERE 1 " . $searchQuery . " AND status in(1, 2) ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset ");
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
                $botones .= "<button type='button' class='btn btn-success text-white' data-toggle='tooltip' data-placement='top' title='Editar Empresa' onclick='editarRegistro(" . $row['nit'] . ");'>";
                $botones .= "<i class='fal fa-edit'></i></button>";
                $botones .= "<button type='button' class='btn btn-" . $statusColor . " text-white' data-toggle='tooltip' data-placement='top' title='Estado de la Empresa' onclick='statusRegistro(" . $row['nit'] . ", " . $row['status'] . ");'>";
                $botones .= "<i class='fal fa-eye'></i></button>";
            }
            if ($datos->d === 1) {
                $botones .= "<button type='button' class='btn btn-danger text-white' data-toggle='tooltip' data-placement='top' title='Eliminar Empresa' onclick='eliminarRegistro(" . $row['nit'] . ");'>";
                $botones .= "<i class='fal fa-trash'></i></button>";
            }
            $botones .= "</div>";

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
                "emaiLogis" => $row['email_logis'],
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

    // -- ⊡ Funcion para cambiar el estado de la empresa ⊡ --
    public function statusEmpresa(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE $this->tableName SET status =? WHERE nit=?";
        $stmt = $this->conn->prepare($query);

        $estado = $this->status == '1' ? '2' : '1';

        // --Almacenamos los valores--
        $stmt->bindParam(1, $estado);
        $stmt->bindParam(2, $this->nit);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para traer datos de la empresa segun nit ⊡ --
    public function dataEmpresa(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT nit, digito, nombre, representante, telefono, direccion, correo, contacto, email_tec, email_logis, content_type, base_64 FROM $this->tableName WHERE nit=? ;";
        $stmt = $this->conn->prepare($query);

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->nit);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {

            // --Comprobamos que venga algun dato--
            if ($stmt->rowCount() >= 1) {

                // --Cosulta a Objetos--
                $data = $stmt->fetch(PDO::FETCH_OBJ);

                $datos = array(
                    'nit' => $data->nit,
                    'digito' => $data->digito,
                    'nombre' => $data->nombre,
                    'representante' => $data->representante,
                    'telefono' => $data->telefono,
                    'direccion' => $data->direccion,
                    'correo' => $data->correo,
                    'contacto' => $data->contacto,
                    'emailTec' => $data->email_tec,
                    'emaiLogis' => $data->email_logis,
                    'contenType' => $data->content_type,
                    'base64' => $data->base_64
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
    public function updateEmpresa(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE $this->tableName SET nit=?, digito=?, nombre=?, representante=?, telefono=?, direccion=?, correo=?, contacto=?,
        email_tec=?, email_logis=?, content_type=?, base_64=? WHERE nit=?";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->nit = htmlspecialchars(strip_tags($this->nit));
        $this->digito = htmlspecialchars(strip_tags($this->digito));
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->representante = htmlspecialchars(strip_tags($this->representante));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        $this->contacto = htmlspecialchars(strip_tags($this->contacto));
        $this->emailTec = htmlspecialchars(strip_tags($this->emailTec));
        $this->emailLogis = htmlspecialchars(strip_tags($this->emailLogis));

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->nit);
        $stmt->bindParam(2, $this->digito);
        $stmt->bindParam(3, $this->nombre);
        $stmt->bindParam(4, $this->representante);
        $stmt->bindParam(5, $this->telefono);
        $stmt->bindParam(6, $this->direccion);
        $stmt->bindParam(7, $this->correo);
        $stmt->bindParam(8, $this->contacto);
        $stmt->bindParam(9, $this->emailTec);
        $stmt->bindParam(10, $this->emailLogis);
        $stmt->bindParam(11, $this->contenType);
        $stmt->bindParam(12, $this->base64);
        $stmt->bindParam(13, $this->id);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para eliminar empresa ⊡ --
    public function deleteEmpresa(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE $this->tableName SET status = 3 WHERE nit=?";
        $stmt = $this->conn->prepare($query);

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->nit);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }
}
