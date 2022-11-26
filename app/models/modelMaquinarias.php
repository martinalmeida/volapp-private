<?php

declare(strict_types=1);

include(MODELS . 'modelSesion.php');

class Maquinaria
{
    // --Parametros Privados--
    private $conn;
    private $tableName = "maquinarias";
    private $tableTpmaquinaria = "tipo_maquinaria";
    private $tableAlquiler = "alquiler";
    private $tableFletes = "fletes";
    private $tableMovimientos = "movimientos";
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
    public $correOperador;
    public $contenType;
    public $base64;
    public $idMaquinaria;
    public $status;
    public $table;

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
    public function createMaquinaria(): void
    {
        // --Preparamos la consulta--
        $query = "INSERT INTO $this->tableName SET placa=?, marca=?, referencia=?, modelo=?, color=?, capacidad=?, nroSerie=?, nroSerieChasis=?, nroMotor=?, rodaje=?, rut=?, gps=?, fechaSoat=?, fechaTecno=?, propietario=?, documentoPropietario=?, telefonoPropietario=?, correoPropietario=?, operador=?, documentOperador=?, telefonOperador=?, correOperador=?, content_type=?, base_64=?, idMaquinaria=?, idUsuario=?, nit=? ;";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->placa = htmlspecialchars(strip_tags($this->placa));
        $this->marca = htmlspecialchars(strip_tags($this->marca));
        $this->referencia = htmlspecialchars(strip_tags($this->referencia));
        $this->modelo = htmlspecialchars(strip_tags($this->modelo));
        $this->color = htmlspecialchars(strip_tags($this->color));
        $this->capacidad = htmlspecialchars(strip_tags($this->capacidad));
        $this->nroSerie = htmlspecialchars(strip_tags($this->nroSerie));
        $this->nroSerieChasis = htmlspecialchars(strip_tags($this->nroSerieChasis));
        $this->nroMotor = htmlspecialchars(strip_tags($this->nroMotor));
        $this->rodaje = htmlspecialchars(strip_tags($this->rodaje));
        $this->rut = htmlspecialchars(strip_tags($this->rut));
        $this->gps = htmlspecialchars(strip_tags($this->gps));
        $this->fechaSoat = htmlspecialchars(strip_tags($this->fechaSoat));
        $this->fechaTecno = htmlspecialchars(strip_tags($this->fechaTecno));
        $this->propietario = htmlspecialchars(strip_tags($this->propietario));
        $this->documentoPropietario = htmlspecialchars(strip_tags($this->documentoPropietario));
        $this->telefonoPropietario = htmlspecialchars(strip_tags($this->telefonoPropietario));
        $this->correoPropietario = htmlspecialchars(strip_tags($this->correoPropietario));
        $this->operador = htmlspecialchars(strip_tags($this->operador));
        $this->documentOperador = htmlspecialchars(strip_tags($this->documentOperador));
        $this->telefonOperador = htmlspecialchars(strip_tags($this->telefonOperador));
        $this->correOperador = htmlspecialchars(strip_tags($this->correOperador));
        $this->contenType = htmlspecialchars(strip_tags($this->contenType));
        $this->base64 = htmlspecialchars(strip_tags($this->base64));
        $this->idMaquinaria = htmlspecialchars(strip_tags($this->idMaquinaria));
        $this->idUser = $_SESSION['id'];
        $this->nit = $_SESSION['nit'];

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->placa);
        $stmt->bindParam(2, $this->marca);
        $stmt->bindParam(3, $this->referencia);
        $stmt->bindParam(4, $this->modelo);
        $stmt->bindParam(5, $this->color);
        $stmt->bindParam(6, $this->capacidad);
        $stmt->bindParam(7, $this->nroSerie);
        $stmt->bindParam(8, $this->nroSerieChasis);
        $stmt->bindParam(9, $this->nroMotor);
        $stmt->bindParam(10, $this->rodaje);
        $stmt->bindParam(11, $this->rut);
        $stmt->bindParam(12, $this->gps);
        $stmt->bindParam(13, $this->fechaSoat);
        $stmt->bindParam(14, $this->fechaTecno);
        $stmt->bindParam(15, $this->propietario);
        $stmt->bindParam(16, $this->documentoPropietario);
        $stmt->bindParam(17, $this->telefonoPropietario);
        $stmt->bindParam(18, $this->correoPropietario);
        $stmt->bindParam(19, $this->operador);
        $stmt->bindParam(20, $this->documentOperador);
        $stmt->bindParam(21, $this->telefonOperador);
        $stmt->bindParam(22, $this->correOperador);
        $stmt->bindParam(23, $this->contenType);
        $stmt->bindParam(24, $this->base64);
        $stmt->bindParam(25, $this->idMaquinaria);
        $stmt->bindParam(26, $this->idUser);
        $stmt->bindParam(27, $this->nit);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para dataTables Serverside ⊡ --
    public function readAllDaTableMaquinaria(): void
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
            $searchQuery = " AND (m.id LIKE :id OR
                            t.tipo LIKE :tipo OR
                            m.placa LIKE :placa OR
                            m.marca LIKE :marca OR
                            m.referencia LIKE :referencia OR
                            m.modelo LIKE :modelo OR
                            m.color LIKE :color OR
                            m.capacidad LIKE :capacidad OR
                            m.nroSerie LIKE :nroSerie OR
                            m.nroSerieChasis LIKE :nroSerieChasis OR
                            m.nroMotor LIKE :nroMotor OR
                            m.rodaje LIKE :rodaje OR
                            m.rut LIKE :rut OR
                            m.gps LIKE :gps OR
                            m.fechaSoat LIKE :fechaSoat OR
                            m.fechaTecno LIKE :fechaTecno OR
                            m.propietario LIKE :propietario OR
                            m.documentoPropietario LIKE :documentoPropietario OR
                            m.telefonoPropietario LIKE :telefonoPropietario OR
                            m.correoPropietario LIKE :correoPropietario OR
                            m.operador LIKE :operador OR
                            m.documentOperador LIKE :documentOperador OR
                            m.telefonOperador LIKE :telefonOperador OR
                            m.correOperador LIKE :correOperador OR
                            m.status LIKE :status )";
            $searchArray = array(
                'id' => "%$searchValue%",
                'tipo' => "%$searchValue%",
                'placa' => "%$searchValue%",
                'marca' => "%$searchValue%",
                'referencia' => "%$searchValue%",
                'modelo' => "%$searchValue%",
                'color' => "%$searchValue%",
                'capacidad' => "%$searchValue%",
                'nroSerie' => "%$searchValue%",
                'nroSerieChasis' => "%$searchValue%",
                'nroMotor' => "%$searchValue%",
                'rodaje' => "%$searchValue%",
                'rut' => "%$searchValue%",
                'gps' => "%$searchValue%",
                'fechaSoat' => "%$searchValue%",
                'fechaTecno' => "%$searchValue%",
                'propietario' => "%$searchValue%",
                'documentoPropietario' => "%$searchValue%",
                'telefonoPropietario' => "%$searchValue%",
                'correoPropietario' => "%$searchValue%",
                'operador' => "%$searchValue%",
                'documentOperador' => "%$searchValue%",
                'telefonOperador' => "%$searchValue%",
                'correOperador' => "%$searchValue%",
                'status' => "%$searchValue%"
            );
        }
        // --Total number of records without filtering--
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS allcount FROM " . $this->tableName . " m JOIN " . $this->tableTpmaquinaria . " t ON m.idMaquinaria = t.id ");
        $stmt->execute();
        $records = $stmt->fetch();
        $totalRecords = $records['allcount'];
        // --Total number of records with filtering--
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS allcount FROM " . $this->tableName . " m JOIN " . $this->tableTpmaquinaria . " t ON m.idMaquinaria = t.id WHERE 1 " . $searchQuery . "");
        $stmt->execute($searchArray);
        $records = $stmt->fetch();
        $totalRecordwithFilter = $records['allcount'];
        // --Fetch records--
        $stmt = $this->conn->prepare("SELECT m.id, t.tipo, m.placa, m.marca, m.referencia, m.modelo, m.color, m.capacidad, m.nroSerie, m.nroSerieChasis, m.nroMotor, m.rodaje, m.rut, m.gps, m.fechaSoat, m.fechaTecno, m.propietario, m.documentoPropietario, m.telefonoPropietario, m.correoPropietario, m.operador, m.documentOperador, m.telefonOperador, m.correOperador, m.content_type, m.base_64, m.status FROM " . $this->tableName . " m JOIN " . $this->tableTpmaquinaria . " t ON m.idMaquinaria = t.id WHERE 1 " . $searchQuery . " AND m.status in(1, 2) AND m.nit =  " . $_SESSION['nit'] . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset ");
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
                $botones .= "<button type='button' class='btn btn-primary text-white' data-toggle='tooltip' data-placement='top' title='Asignar tipo de facturación' onclick='showModalAsignar(" . $row['id'] . ");'>";
                $botones .= "<i class='fal fa-comment-dollar'></i></button>";
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
                "tipo" => $row['tipo'],
                "placa" => $row['placa'],
                "marca" => $row['marca'],
                "referencia" => $row['referencia'],
                "modelo" => $row['modelo'],
                "color" => $row['color'],
                "capacidad" => $row['capacidad'],
                "nroSerie" => $row['nroSerie'],
                "nroSerieChasis" => $row['nroSerieChasis'],
                "nroMotor" => $row['nroMotor'],
                "rodaje" => $row['rodaje'],
                "rut" => $row['rut'],
                "gps" => $row['gps'],
                "fechaSoat" => $row['fechaSoat'],
                "fechaTecno" => $row['fechaTecno'],
                "propietario" => $row['propietario'],
                "documentoPropietario" => $row['documentoPropietario'],
                "telefonoPropietario" => $row['telefonoPropietario'],
                "correoPropietario" => $row['correoPropietario'],
                "operador" => $row['operador'],
                "documentOperador" => $row['documentOperador'],
                "telefonOperador" => $row['telefonOperador'],
                "correOperador" => $row['correOperador'],
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
    public function statusMaquinaria(): void
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
    public function dataMaquinaria(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT id, placa, marca, referencia, modelo, color, capacidad, nroSerie, nroSerieChasis, nroMotor, rodaje, rut, gps, fechaSoat, fechaTecno, propietario, documentoPropietario, telefonoPropietario, correoPropietario, operador, documentOperador, telefonOperador, correOperador, (content_type)contenType, (base_64)base64, idMaquinaria  FROM $this->tableName WHERE id=? ;";
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
    public function updateMaquinaria(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE $this->tableName SET placa=?, marca=?, referencia=?, modelo=?, color=?, capacidad=?, nroSerie=?, nroSerieChasis=?, nroMotor=?, rodaje=?, rut=?, gps=?, fechaSoat=?, fechaTecno=?, propietario=?, documentoPropietario=?, telefonoPropietario=?, correoPropietario=?, operador=?, documentOperador=?, telefonOperador=?, correOperador=?, content_type=?, base_64=?, idMaquinaria=?, idUsuario=?, nit=? WHERE id=?";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->placa = htmlspecialchars(strip_tags($this->placa));
        $this->marca = htmlspecialchars(strip_tags($this->marca));
        $this->referencia = htmlspecialchars(strip_tags($this->referencia));
        $this->modelo = htmlspecialchars(strip_tags($this->modelo));
        $this->color = htmlspecialchars(strip_tags($this->color));
        $this->capacidad = htmlspecialchars(strip_tags($this->capacidad));
        $this->nroSerie = htmlspecialchars(strip_tags($this->nroSerie));
        $this->nroSerieChasis = htmlspecialchars(strip_tags($this->nroSerieChasis));
        $this->nroMotor = htmlspecialchars(strip_tags($this->nroMotor));
        $this->rodaje = htmlspecialchars(strip_tags($this->rodaje));
        $this->rut = htmlspecialchars(strip_tags($this->rut));
        $this->gps = htmlspecialchars(strip_tags($this->gps));
        $this->fechaSoat = htmlspecialchars(strip_tags($this->fechaSoat));
        $this->fechaTecno = htmlspecialchars(strip_tags($this->fechaTecno));
        $this->propietario = htmlspecialchars(strip_tags($this->propietario));
        $this->documentoPropietario = htmlspecialchars(strip_tags($this->documentoPropietario));
        $this->telefonoPropietario = htmlspecialchars(strip_tags($this->telefonoPropietario));
        $this->correoPropietario = htmlspecialchars(strip_tags($this->correoPropietario));
        $this->operador = htmlspecialchars(strip_tags($this->operador));
        $this->documentOperador = htmlspecialchars(strip_tags($this->documentOperador));
        $this->telefonOperador = htmlspecialchars(strip_tags($this->telefonOperador));
        $this->correOperador = htmlspecialchars(strip_tags($this->correOperador));
        $this->contenType = htmlspecialchars(strip_tags($this->contenType));
        $this->base64 = htmlspecialchars(strip_tags($this->base64));
        $this->idMaquinaria = htmlspecialchars(strip_tags($this->idMaquinaria));
        $this->idUser = $_SESSION['id'];
        $this->nit = $_SESSION['nit'];

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->placa);
        $stmt->bindParam(2, $this->marca);
        $stmt->bindParam(3, $this->referencia);
        $stmt->bindParam(4, $this->modelo);
        $stmt->bindParam(5, $this->color);
        $stmt->bindParam(6, $this->capacidad);
        $stmt->bindParam(7, $this->nroSerie);
        $stmt->bindParam(8, $this->nroSerieChasis);
        $stmt->bindParam(9, $this->nroMotor);
        $stmt->bindParam(10, $this->rodaje);
        $stmt->bindParam(11, $this->rut);
        $stmt->bindParam(12, $this->gps);
        $stmt->bindParam(13, $this->fechaSoat);
        $stmt->bindParam(14, $this->fechaTecno);
        $stmt->bindParam(15, $this->propietario);
        $stmt->bindParam(16, $this->documentoPropietario);
        $stmt->bindParam(17, $this->telefonoPropietario);
        $stmt->bindParam(18, $this->correoPropietario);
        $stmt->bindParam(19, $this->operador);
        $stmt->bindParam(20, $this->documentOperador);
        $stmt->bindParam(21, $this->telefonOperador);
        $stmt->bindParam(22, $this->correOperador);
        $stmt->bindParam(23, $this->contenType);
        $stmt->bindParam(24, $this->base64);
        $stmt->bindParam(25, $this->idMaquinaria);
        $stmt->bindParam(26, $this->idUser);
        $stmt->bindParam(27, $this->nit);
        $stmt->bindParam(28, $this->id);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para eliminar rol ⊡ --
    public function deleteMaquinaria(): void
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

    // -- ⊡ Funcion para checar si ya esta maquinaria esta asociada a un acuerdo ⊡ --
    public function checkMaquinariaAcuerdo(): void
    {
        $tablas = array($this->tableAlquiler, $this->tableFletes, $this->tableMovimientos);
        foreach ($tablas as $tabla) {
            // --Preparamos la consulta--
            $query = "SELECT * FROM $tabla WHERE idMaquinaria=? ;";
            $stmt = $this->conn->prepare($query);

            // --Almacenamos los valores--
            $stmt->bindParam(1, $this->id);

            // --Ejecutamos la consulta y validamos ejecucion--
            if ($stmt->execute()) {

                // --Comprobamos que venga algun dato--
                if ($stmt->rowCount() >= 1) {

                    // --Retornamos las respuestas--
                    echo json_encode(array('status' => '1', 'data' => NULL));
                    exit;
                }
            } else {
                // --Falla en la ejecución de la consulta--
                echo json_encode(array('status' => '0', 'data' => NULL));
                exit;
            }
        }
        echo json_encode(array('status' => '3', 'data' => NULL));
    }

    function asignarModoFacturacion(): void
    {
        switch ($this->table) {
            case '1':
                $query = "INSERT INTO $this->tableAlquiler SET idMaquinaria=?, datecreated=?, idUsuario=? ;";
                break;
            case '2':
                $query = "INSERT INTO $this->tableFletes SET idMaquinaria=?, datecreated=?, idUsuario=? ;";
                break;
            case '3':
                $query = "INSERT INTO $this->tableMovimientos SET idMaquinaria=?, datecreated=?, idUsuario=? ;";
                break;

            default:
                // code
                break;
        }

        $stmt = $this->conn->prepare($query);
        // --Escapamos los caracteres--
        $this->fechaActual = Utilidades::getFecha();
        $this->idUser = $_SESSION['id'];

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->id);
        $stmt->bindParam(2, $this->fechaActual);
        $stmt->bindParam(3, $this->idUser);
        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }
}
