<?php

declare(strict_types=1);

include(MODELS . 'modelSesion.php');

class Usuario
{
    // --Parametros Privados--
    private $conn;
    private $tableName = "usuarios";
    private $tableRol = "rol";
    private $tableSucursal = "sucursal";

    // --Parametros Publicos--
    public $identificacion;
    public $nombres;
    public $Apaterno;
    public $Amaterno;
    public $telefono;
    public $emailUser;
    public $pswd;
    public $nombreFiscal;
    public $direccionFiscal;
    public $contenType;
    public $base64;
    public $rol;
    public $sucursal;
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
            $html .= '<i class="fal fa-info-circle"></i> Usuarios</h1>';
            $html .= '<button type="button" class="btn btn-info active" onclick="showModalRegistro();">Agregar <i class="fal fa-plus-square"></i></button>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        } else {

            $html = "";
            $html .= '<h1 class="subheader-title">';
            $html .= '<i class="fal fa-info-circle"></i> Usuarios</h1>';
            $html .= '<h3>No tienes permisos de escritura para este modulo.</h3>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        }
    }

    // -- ⊡ Funcion para crear una empresa ⊡ --
    public function createUsuario(): void
    {
        // --Preparamos la consulta--
        $query = "INSERT INTO $this->tableName SET identificacion=?, nombres=?, a_paterno=?, a_materno=?, telefono=?, email_user=?, pswd=?,
        nombrefiscal=?, direccionfiscal=?, content_type=?, base_64=?, rolid =?, sucursalid =? ;";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->identificacion = htmlspecialchars(strip_tags($this->identificacion));
        $this->nombres = htmlspecialchars(strip_tags($this->nombres));
        $this->Apaterno = htmlspecialchars(strip_tags($this->Apaterno));
        $this->Amaterno = htmlspecialchars(strip_tags($this->Amaterno));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->emailUser = htmlspecialchars(strip_tags($this->emailUser));
        $this->pswd = htmlspecialchars(strip_tags($this->pswd));
        $this->nombreFiscal = htmlspecialchars(strip_tags($this->nombreFiscal));
        $this->direccionFiscal = htmlspecialchars(strip_tags($this->direccionFiscal));
        $this->contenType = htmlspecialchars(strip_tags($this->contenType));
        $this->base64 = htmlspecialchars(strip_tags($this->base64));
        $this->rol = htmlspecialchars(strip_tags($this->rol));
        $this->sucursal = htmlspecialchars(strip_tags($this->sucursal));

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->identificacion);
        $stmt->bindParam(2, $this->nombres);
        $stmt->bindParam(3, $this->Apaterno);
        $stmt->bindParam(4, $this->Amaterno);
        $stmt->bindParam(5, $this->telefono);
        $stmt->bindParam(6, $this->emailUser);
        $stmt->bindParam(7, $this->pswd);
        $stmt->bindParam(8, $this->nombreFiscal);
        $stmt->bindParam(9, $this->direccionFiscal);
        $stmt->bindParam(10, $this->contenType);
        $stmt->bindParam(11, $this->base64);
        $stmt->bindParam(12, $this->rol);
        $stmt->bindParam(13, $this->sucursal);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para dataTables Serverside ⊡ --
    public function readAllDaTableUsario(): void
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
            $searchQuery = " AND (identificacion LIKE :identificacion OR
                            nombres LIKE :nombres OR
                            a_paterno LIKE :a_paterno OR 
                            a_materno LIKE :a_materno OR
                            email_user LIKE :email_user OR
                            pswd LIKE :pswd OR
                            nombrefiscal LIKE :nombrefiscal OR
                            direccionfiscal LIKE :direccionfiscal  )";
            $searchArray = array(
                'identificacion' => "%$searchValue%",
                'nombres' => "%$searchValue%",
                'a_paterno' => "%$searchValue%",
                'a_materno' => "%$searchValue%",
                'email_user' => "%$searchValue%",
                'pswd' => "%$searchValue%",
                'nombrefiscal' => "%$searchValue%",
                'direccionfiscal' => "%$searchValue%"
            );
        }
        // --Total number of records without filtering--
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS allcount FROM $this->tableName");
        $stmt->execute();
        $records = $stmt->fetch();
        $totalRecords = $records['allcount'];
        // --Total number of records with filtering--
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS allcount FROM $this->tableName WHERE 1 $searchQuery");
        $stmt->execute($searchArray);
        $records = $stmt->fetch();
        $totalRecordwithFilter = $records['allcount'];
        // --Fetch records--
        $stmt = $this->conn->prepare("SELECT 
                                      u.id, u.identificacion, u.nombres, u.a_paterno, u.a_materno, u.telefono, u.email_user, 
                                      u.pswd, u.nombrefiscal, u.direccionfiscal, r.nombrerol, s.descripcion, u.status 
                                      FROM $this->tableName u  
                                      JOIN $this->tableRol r ON u.rolid = r.id 
                                      JOIN $this->tableSucursal s ON u.sucursalid = s.id 
                                      WHERE 1 $searchQuery AND u.status in(1, 2) ORDER BY $columnName $columnSortOrder LIMIT :limit,:offset ");
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
                $botones .= "<button type='button' class='btn btn-success text-white' data-toggle='tooltip' data-placement='top' title='Editar Empresa' onclick='editarRegistro(" . $row['id'] . ");'>";
                $botones .= "<i class='fal fa-edit'></i></button>";
                $botones .= "<button type='button' class='btn btn-" . $statusColor . " text-white' data-toggle='tooltip' data-placement='top' title='Estado de la Empresa' onclick='statusRegistro(" . $row['id'] . ", " . $row['status'] . ");'>";
                $botones .= "<i class='fal fa-eye'></i></button>";
            }
            if ($datos->d === 1) {
                $botones .= "<button type='button' class='btn btn-danger text-white' data-toggle='tooltip' data-placement='top' title='Eliminar Empresa' onclick='eliminarRegistro(" . $row['id'] . ");'>";
                $botones .= "<i class='fal fa-trash'></i></button>";
            }
            $botones .= "</div>";

            $data[] = array(
                "id" => $row['id'],
                "identificacion" => $row['identificacion'],
                "nombres" => $row['nombres'],
                "a_paterno" => $row['a_paterno'],
                "a_materno" => $row['a_materno'],
                "telefono" => $row['telefono'],
                "email_user" => $row['email_user'],
                "pswd" => $row['pswd'],
                "nombrefiscal" => $row['nombrefiscal'],
                "direccionfiscal" => $row['direccionfiscal'],
                "nombrerol" => $row['nombrerol'],
                "descripcion" => $row['descripcion'],
                "status" => $estado,
                "defaultContent" => $botones
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
    public function statusUsuario(): void
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

    // -- ⊡ Funcion para traer datos de la empresa segun nit ⊡ --
    public function dataUsuario(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT id, identificacion, nombres, a_paterno, a_materno, telefono, email_user, pswd, nombrefiscal, direccionfiscal, content_type, base_64, rolid, sucursalid FROM $this->tableName WHERE id=? ;";
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
                    'identificacion' => $data->identificacion,
                    'nombres' => $data->nombres,
                    'Apaterno' => $data->a_paterno,
                    'Amaterno' => $data->a_materno,
                    'telefono' => $data->telefono,
                    'emailUser' => $data->email_user,
                    'pswd' => $data->pswd,
                    'nombreFiscal' => $data->nombrefiscal,
                    'direccionFiscal' => $data->direccionfiscal,
                    'contenType' => $data->content_type,
                    'base64' => $data->base_64,
                    'rol' => $data->rolid,
                    'sucursal' => $data->sucursalid
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
    public function updateUsuario(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE $this->tableName SET identificacion=?, nombres=?, a_paterno=?, a_materno=?, telefono=?, email_user=?, pswd=?, nombrefiscal=?,
        direccionfiscal=?, content_type=?, base_64=?, rolid =?, sucursalid =? WHERE id=?";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->identificacion = htmlspecialchars(strip_tags($this->identificacion));
        $this->nombres = htmlspecialchars(strip_tags($this->nombres));
        $this->Apaterno = htmlspecialchars(strip_tags($this->Apaterno));
        $this->Amaterno = htmlspecialchars(strip_tags($this->Amaterno));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->emailUser = htmlspecialchars(strip_tags($this->emailUser));
        $this->pswd = htmlspecialchars(strip_tags($this->pswd));
        $this->nombreFiscal = htmlspecialchars(strip_tags($this->nombreFiscal));
        $this->direccionFiscal = htmlspecialchars(strip_tags($this->direccionFiscal));
        $this->rol = htmlspecialchars(strip_tags($this->rol));
        $this->sucursal = htmlspecialchars(strip_tags($this->sucursal));

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->identificacion);
        $stmt->bindParam(2, $this->nombres);
        $stmt->bindParam(3, $this->Apaterno);
        $stmt->bindParam(4, $this->Amaterno);
        $stmt->bindParam(5, $this->telefono);
        $stmt->bindParam(6, $this->emailUser);
        $stmt->bindParam(7, $this->pswd);
        $stmt->bindParam(8, $this->nombreFiscal);
        $stmt->bindParam(9, $this->direccionFiscal);
        $stmt->bindParam(10, $this->contenType);
        $stmt->bindParam(11, $this->base64);
        $stmt->bindParam(12, $this->rol);
        $stmt->bindParam(13, $this->sucursal);
        $stmt->bindParam(14, $this->id);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para eliminar empresa ⊡ --
    public function deleteUsuario(): void
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
