<?php

declare(strict_types=1);

include(MODELS . 'modelSesion.php');

class RegistrosFletes
{
    // --Parametros Privados--
    private $conn;
    private $nombreSubModulo = 'registros';
    private $tableName = "registros_fletes";
    private $tableDeducible = "deducibles_fletes";
    private $viewTable = "view_registro_fletes";
    private $fechaActual;
    private $nit;

    // --Parametros Publicos--
    public $id;
    public $placa;
    public $acuerdo;
    public $codFicha;
    public $fechaInicio;
    public $fechaFin;
    public $admon;
    public $retefuente;
    public $reteica;
    public $anticipo;
    public $otros;
    public $observacion;
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
        $sesion->tabla = $this->nombreSubModulo;

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
        $sesion->tabla = $this->nombreSubModulo;

        $datos = $sesion->permisoModulo();
        $html = "";

        if ($datos->w === 1) {

            $html .= '<h1 class="subheader-title">';
            $html .= '<i class="fal fa-info-circle"></i> Registros de Fletes</h1>';
            $html .= '<button type="button" class="btn btn-primary active m-1" onClick="history.go(-1); return false;"><i class="fal fa-arrow-left"></i> Regresar</button>';
            $html .= '<button type="button" class="btn btn-info active" onclick="showModalRegistro();">Agregar <i class="fal fa-plus-square"></i></button>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        } else {

            $html .= '<h1 class="subheader-title">';
            $html .= '<i class="fal fa-info-circle"></i> Registros de Fletes</h1>';
            $html .= '<button type="button" class="btn btn-primary active m-1" onClick="history.go(-1); return false;"><i class="fal fa-arrow-left"></i> Regresar</button>';
            $html .= '<h3>No tienes permisos de escritura para este modulo.</h3>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        }
    }

    // -- ⊡ Funcion para crear un registro ⊡ --
    public function createRegistro(): void
    {
        // --Preparamos la consulta--
        $query = "INSERT INTO $this->tableName SET idMaquinaria=?, idFlete=?, codFicha=?, fechaInicio=?, fechaFin=?, observacion=?, datecreated=?, idUsuario=?, nit=? ;";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->placa = htmlspecialchars(strip_tags($this->placa));
        $this->acuerdo = htmlspecialchars(strip_tags($this->acuerdo));
        $this->codFicha = htmlspecialchars(strip_tags($this->codFicha));
        $this->fechaInicio = htmlspecialchars(strip_tags($this->fechaInicio));
        $this->fechaFin = htmlspecialchars(strip_tags($this->fechaFin));
        $this->observacion = htmlspecialchars(strip_tags($this->observacion));
        $this->fechaActual = Utilidades::getFecha();
        $this->idUser = $_SESSION['id'];
        $this->nit = $_SESSION['nit'];

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->placa);
        $stmt->bindParam(2, $this->acuerdo);
        $stmt->bindParam(3, $this->codFicha);
        $stmt->bindParam(4, $this->fechaInicio);
        $stmt->bindParam(5, $this->fechaFin);
        $stmt->bindParam(6, $this->observacion);
        $stmt->bindParam(7, $this->fechaActual);
        $stmt->bindParam(8, $this->idUser);
        $stmt->bindParam(9, $this->nit);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para dataTables Serverside ⊡ --
    public function readAllDaTableRegistro(): void
    {
        $sesion = new Sesion($this->conn);
        $sesion->rol = $_SESSION['rol'];
        $sesion->tabla = $this->nombreSubModulo;
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
                            codFicha LIKE :codFicha OR
                            placa LIKE :placa OR
                            acuerdo LIKE :acuerdo OR
                            flete LIKE :flete OR
                            fechaInicio LIKE :fechaInicio OR
                            fechaFin LIKE :fechaFin OR
                            titulo LIKE :titulo OR
                            observacion LIKE :observacion OR
                            nombres LIKE :nombres OR
                            status LIKE :status )";
            $searchArray = array(
                'id' => "%$searchValue%",
                'codFicha' => "%$searchValue%",
                'placa' => "%$searchValue%",
                'acuerdo' => "%$searchValue%",
                'flete' => "%$searchValue%",
                'fechaInicio' => "%$searchValue%",
                'fechaFin' => "%$searchValue%",
                'titulo' => "%$searchValue%",
                'observacion' => "%$searchValue%",
                'nombres' => "%$searchValue%",
                'status' => "%$searchValue%"
            );
        }
        // --Total number of records without filtering--
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS allcount FROM $this->viewTable WHERE status IN(1, 2) AND nit = " . $_SESSION['nit'] . " ");
        $stmt->execute();
        $records = $stmt->fetch();
        $totalRecords = $records['allcount'];
        // --Total number of records with filtering--
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS allcount FROM $this->viewTable WHERE 1 " . $searchQuery . " AND nit = " . $_SESSION['nit'] . " ");
        $stmt->execute($searchArray);
        $records = $stmt->fetch();
        $totalRecordwithFilter = $records['allcount'];
        // --Fetch records--
        $stmt = $this->conn->prepare("SELECT * FROM $this->viewTable  WHERE 1 $searchQuery 
                                      AND status IN(1, 2) AND nit = " . $_SESSION['nit'] . " ORDER BY $columnName $columnSortOrder LIMIT :limit,:offset ");
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
                $botones .= "<button type='button' class='btn btn-success text-white' data-toggle='tooltip' data-placement='top' title='Editar Registro' onclick='editarRegistro(" . $row['id'] . ");'>";
                $botones .= "<i class='fal fa-edit'></i></button>";
                $botones .= "<button type='button' class='btn btn-" . $statusColor . " text-white' data-toggle='tooltip' data-placement='top' title='Estado del Registro' onclick='statusRegistro(" . $row['id'] . ", " . $row['status'] . ");'>";
                $botones .= "<i class='fal fa-eye'></i></button>";
                $botones .= '<button type="button" class="btn btn-primary text-white" data-toggle="tooltip" data-placement="top" title="Agregar Descontables" onclick="deducibles(' . $row['id'] . ', \'' . $row['placa'] . '\');">';
                $botones .= "<i class='fal fa-file-invoice-dollar'></i></button>";
            }
            if ($datos->d === 1) {
                $botones .= "<button type='button' class='btn btn-danger text-white' data-toggle='tooltip' data-placement='top' title='Eliminar Registro' onclick='eliminarRegistro(" . $row['id'] . ");'>";
                $botones .= "<i class='fal fa-trash'></i></button>";
            }
            $botones .= "</div>";

            $data[] = array(
                "id" => $row['id'],
                "codFicha" => $row['codFicha'],
                "placa" => $row['placa'],
                "acuerdo" => $row['acuerdo'],
                "flete" => $row['flete'],
                "fechaInicio" => $row['fechaInicio'],
                "fechaFin" => $row['fechaFin'],
                "titulo" => $row['titulo'],
                "observacion" => $row['observacion'],
                "nombres" => $row['nombres'],
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
    public function statusRegistro(): void
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
    public function dataRegistro(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT * FROM $this->tableName WHERE id=? ;";
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
    public function updateRegistro(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE $this->tableName SET idMaquinaria=?, idFlete=?, codFicha=?, fechaInicio=?, fechaFin=?, observacion=?, dateupdate=?, idUsuario=?, nit=? WHERE id=? ;";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->placa = htmlspecialchars(strip_tags($this->placa));
        $this->acuerdo = htmlspecialchars(strip_tags($this->acuerdo));
        $this->codFicha = htmlspecialchars(strip_tags($this->codFicha));
        $this->fechaInicio = htmlspecialchars(strip_tags($this->fechaInicio));
        $this->fechaFin = htmlspecialchars(strip_tags($this->fechaFin));
        $this->observacion = htmlspecialchars(strip_tags($this->observacion));
        $this->fechaActual = Utilidades::getFecha();
        $this->idUser = $_SESSION['id'];
        $this->nit = $_SESSION['nit'];

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->placa);
        $stmt->bindParam(2, $this->acuerdo);
        $stmt->bindParam(3, $this->codFicha);
        $stmt->bindParam(4, $this->fechaInicio);
        $stmt->bindParam(5, $this->fechaFin);
        $stmt->bindParam(6, $this->observacion);
        $stmt->bindParam(7, $this->fechaActual);
        $stmt->bindParam(8, $this->idUser);
        $stmt->bindParam(9, $this->nit);
        $stmt->bindParam(10, $this->id);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para eliminar rol ⊡ --
    public function deleteRegistro(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE $this->tableName SET datedelete=?, status = 3 WHERE id=?";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->fechaActual = Utilidades::getFecha();

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->fechaActual);
        $stmt->bindParam(2, $this->id);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para ingresar un deducible ⊡ --
    public function createDeducible(): void
    {
        // --Preparamos la consulta--
        $query = "INSERT INTO $this->tableDeducible SET admon=?, retefuente=?, reteica=?, anticipo=?, otros=?, observacion=?, datecreated=?, idRegistro=?, idUsuario=? ;";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->admon = htmlspecialchars(strip_tags($this->admon));
        $this->retefuente = htmlspecialchars(strip_tags($this->retefuente));
        $this->reteica = htmlspecialchars(strip_tags($this->reteica));
        $this->anticipo = htmlspecialchars(strip_tags($this->anticipo));
        $this->otros = htmlspecialchars(strip_tags($this->otros));
        $this->observacion = htmlspecialchars(strip_tags($this->observacion));
        $this->fechaActual = Utilidades::getFecha();
        $this->idUser = $_SESSION['id'];

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->admon);
        $stmt->bindParam(2, $this->retefuente);
        $stmt->bindParam(3, $this->reteica);
        $stmt->bindParam(4, $this->anticipo);
        $stmt->bindParam(5, $this->otros);
        $stmt->bindParam(6, $this->observacion);
        $stmt->bindParam(7, $this->fechaActual);
        $stmt->bindParam(8, $this->id);
        $stmt->bindParam(9, $this->idUser);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para ingresar un deducible ⊡ --
    public function updateDeducible(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE $this->tableDeducible SET admon=?, retefuente=?, reteica=?, anticipo=?, otros=?, observacion=?, dateUpdate=?, idUsuario=? WHERE id=? ;";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->admon = htmlspecialchars(strip_tags($this->admon));
        $this->retefuente = htmlspecialchars(strip_tags($this->retefuente));
        $this->reteica = htmlspecialchars(strip_tags($this->reteica));
        $this->anticipo = htmlspecialchars(strip_tags($this->anticipo));
        $this->otros = htmlspecialchars(strip_tags($this->otros));
        $this->observacion = htmlspecialchars(strip_tags($this->observacion));
        $this->fechaActual = Utilidades::getFecha();
        $this->idUser = $_SESSION['id'];

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->admon);
        $stmt->bindParam(2, $this->retefuente);
        $stmt->bindParam(3, $this->reteica);
        $stmt->bindParam(4, $this->anticipo);
        $stmt->bindParam(5, $this->otros);
        $stmt->bindParam(6, $this->observacion);
        $stmt->bindParam(7, $this->fechaActual);
        $stmt->bindParam(8, $this->idUser);
        $stmt->bindParam(9, $this->id);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para traer datos de dedubles ⊡ --
    public function dataDeducible(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT * FROM $this->tableDeducible WHERE idRegistro=? ;";
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
}
