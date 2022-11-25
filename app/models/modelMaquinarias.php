<?php

declare(strict_types=1);

include(MODELS . 'modelSesion.php');

class Vehiculo
{
    // --Parametros Privados--
    private $conn;
    private $tableName = "maquinarias";
    private $tableTpvehiculo = "tipo_vehiculo";
    private $nit;
    private $idUser;

    // --Parametros Publicos--
    public $id;
    public $placa;
    public $marca;
    public $referencia;
    public $modelo;
    public $color;
    public $capacidad;
    public $nroSerie;
    public $nroSerieChasis;
    public $nroMotor;
    public $rodaje;
    public $rut;
    public $gps;
    public $fechaSoat;
    public $fechaTecno;
    public $propietario;
    public $documentoPropietario;
    public $telefonoPropietario;
    public $correoPropietario;
    public $operador;
    public $documentOperador;
    public $telefonOperador;
    public $correoOperador;
    public $contenType;
    public $base64;
    public $idMaquinaria;
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
            $html .= '<i class="fal fa-info-circle"></i> Maquinarias</h1>';
            $html .= '<button type="button" class="btn btn-info active" onclick="showModalRegistro();">Agregar <i class="fal fa-plus-square"></i></button>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        } else {

            $html = "";
            $html .= '<h1 class="subheader-title">';
            $html .= '<i class="fal fa-info-circle"></i> Maquinarias</h1>';
            $html .= '<h3>No tienes permisos de escritura para este modulo.</h3>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        }
    }

    // -- ⊡ Funcion para crear un rol ⊡ --
    public function createPlaca(): void
    {
        // --Preparamos la consulta--
        $query = "INSERT INTO $this->tableName SET 
                  placa=?, nombresConductor=?, telefono=?, email=?, fechaSoat=?, fechaLicencia=?, fecchaTdr=?, content_type=?, base_64=?, tp_vehiculoId=?, idUsuario=?, nit=? ;";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->placa = htmlspecialchars(strip_tags($this->placa));
        $this->nombresConductor = htmlspecialchars(strip_tags($this->nombresConductor));
        // $this->Apaterno = htmlspecialchars(strip_tags($this->Apaterno));
        // $this->Amaterno = htmlspecialchars(strip_tags($this->Amaterno));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->fechaSoat = htmlspecialchars(strip_tags($this->fechaSoat));
        $this->fechaLicencia = htmlspecialchars(strip_tags($this->fechaLicencia));
        $this->fecchaTdr = htmlspecialchars(strip_tags($this->fecchaTdr));
        $this->contenType = htmlspecialchars(strip_tags($this->contenType));
        $this->base64 = htmlspecialchars(strip_tags($this->base64));
        $this->tpVehiculo = htmlspecialchars(strip_tags($this->tpVehiculo));
        $this->idUser = $_SESSION['id'];
        $this->nit = $_SESSION['nit'];

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->placa);
        $stmt->bindParam(2, $this->nombresConductor);
        // $stmt->bindParam(3, $this->Apaterno);
        // $stmt->bindParam(4, $this->Amaterno);
        $stmt->bindParam(3, $this->telefono);
        $stmt->bindParam(4, $this->email);
        $stmt->bindParam(5, $this->fechaSoat);
        $stmt->bindParam(6, $this->fechaLicencia);
        $stmt->bindParam(7, $this->fecchaTdr);
        $stmt->bindParam(8, $this->contenType);
        $stmt->bindParam(9, $this->base64);
        $stmt->bindParam(10, $this->tpVehiculo);
        $stmt->bindParam(11, $this->idUser);
        $stmt->bindParam(12, $this->nit);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para dataTables Serverside ⊡ --
    public function readAllDaTablePlacas(): void
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
                            placa LIKE :placa OR
                            nombresConductor LIKE :nombresConductor OR
                            telefono LIKE :telefono OR
                            email LIKE :email OR
                            fechaSoat LIKE :fechaSoat OR
                            fechaLicencia LIKE :fechaLicencia OR
                            fecchaTdr LIKE :fecchaTdr OR
                            status LIKE :status )";
            $searchArray = array(
                'id' => "%$searchValue%",
                'placa' => "%$searchValue%",
                'nombresConductor' => "%$searchValue%",
                'telefono' => "%$searchValue%",
                'email' => "%$searchValue%",
                'fechaSoat' => "%$searchValue%",
                'fechaLicencia' => "%$searchValue%",
                'fecchaTdr' => "%$searchValue%",
                'status' => "%$searchValue%"
            );
        }
        // --Total number of records without filtering--
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS allcount FROM " . $this->tableName . " ");
        $stmt->execute();
        $records = $stmt->fetch();
        $totalRecords = $records['allcount'];
        // --Total number of records with filtering--
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS allcount FROM " . $this->tableName . "  WHERE 1 " . $searchQuery . "");
        $stmt->execute($searchArray);
        $records = $stmt->fetch();
        $totalRecordwithFilter = $records['allcount'];
        // --Fetch records--
        $stmt = $this->conn->prepare("SELECT id, placa, nombresConductor, telefono, email, fechaSoat, fechaLicencia, fecchaTdr, content_type, base_64, status FROM " . $this->tableName . " WHERE 1 " . $searchQuery . " AND status in(1, 2) ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset ");
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
                $botones .= '<button type="button" class="btn btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Ver docuemntación del vehiculo en PDF" onclick="visualizarPDF(';
                $botones .= "'" . $row['content_type'] . "', '" . $row['base_64'] . "'); ";
                $botones .= '"><i class="fal fa-file-pdf"></i></button>';
            }
            if ($datos->u === 1) {
                $botones .= "<button type='button' class='btn btn-success text-white' data-toggle='tooltip' data-placement='top' title='Editar Vehiculo' onclick='editarRegistro(" . $row['id'] . ");'>";
                $botones .= "<i class='fal fa-edit'></i></button>";
                $botones .= "<button type='button' class='btn btn-" . $statusColor . " text-white' data-toggle='tooltip' data-placement='top' title='Estado del Vehiculo' onclick='statusRegistro(" . $row['id'] . ", " . $row['status'] . ");'>";
                $botones .= "<i class='fal fa-eye'></i></button>";
            }
            if ($datos->d === 1) {
                $botones .= "<button type='button' class='btn btn-danger text-white' data-toggle='tooltip' data-placement='top' title='Eliminar Vehiculo' onclick='eliminarRegistro(" . $row['id'] . ");'>";
                $botones .= "<i class='fal fa-trash'></i></button>";
            }
            $botones .= "</div>";

            $data[] = array(
                "id" => $row['id'],
                "placa" => $row['placa'],
                "nombresConductor" => $row['nombresConductor'],
                "telefono" => $row['telefono'],
                "email" => $row['email'],
                "fechaSoat" => $row['fechaSoat'],
                "fechaLicencia" => $row['fechaLicencia'],
                "fecchaTdr" => $row['fecchaTdr'],
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
    public function statusPLaca(): void
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
    public function dataVehiculo(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT id, placa, nombresConductor, Apaterno, Amaterno, telefono, email, fechaSoat, fechaLicencia, fecchaTdr, (content_type)contenType, (base_64)base64, (tp_vehiculoId)tpVehiculo FROM $this->tableName WHERE id=? ;";
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
    public function updatePlaca(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE $this->tableName SET placa=?, nombresConductor=?, telefono=?, email=?, fechaSoat=?, fechaLicencia=?, fecchaTdr=?, content_type=?, base_64=?, tp_vehiculoId=?, idUsuario=?, nit=? WHERE id=?";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->placa = htmlspecialchars(strip_tags($this->placa));
        $this->nombresConductor = htmlspecialchars(strip_tags($this->nombresConductor));
        // $this->Apaterno = htmlspecialchars(strip_tags($this->Apaterno));
        // $this->Amaterno = htmlspecialchars(strip_tags($this->Amaterno));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->fechaSoat = htmlspecialchars(strip_tags($this->fechaSoat));
        $this->fechaLicencia = htmlspecialchars(strip_tags($this->fechaLicencia));
        $this->fecchaTdr = htmlspecialchars(strip_tags($this->fecchaTdr));
        $this->contenType = htmlspecialchars(strip_tags($this->contenType));
        $this->base64 = htmlspecialchars(strip_tags($this->base64));
        $this->tpVehiculo = htmlspecialchars(strip_tags($this->tpVehiculo));
        $this->idUser = $_SESSION['id'];
        $this->nit = $_SESSION['nit'];

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->placa);
        $stmt->bindParam(2, $this->nombresConductor);
        // $stmt->bindParam(3, $this->Apaterno);
        // $stmt->bindParam(4, $this->Amaterno);
        $stmt->bindParam(3, $this->telefono);
        $stmt->bindParam(4, $this->email);
        $stmt->bindParam(5, $this->fechaSoat);
        $stmt->bindParam(6, $this->fechaLicencia);
        $stmt->bindParam(7, $this->fecchaTdr);
        $stmt->bindParam(8, $this->contenType);
        $stmt->bindParam(9, $this->base64);
        $stmt->bindParam(10, $this->tpVehiculo);
        $stmt->bindParam(11, $this->idUser);
        $stmt->bindParam(12, $this->nit);
        $stmt->bindParam(13, $this->id);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para eliminar rol ⊡ --
    public function deletePlaca(): void
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
