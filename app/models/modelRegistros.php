<?php

declare(strict_types=1);

include(MODELS . 'modelSesion.php');

class Registro
{
    // --Parametros Privados--
    private $conn;
    private $tableName = "registros";
    private $tablePlaca = "vehiculos";
    private $tableRuta = "rutas";
    private $tableMaterial = "materiales";
    private $tableUser = "usuarios";
    private $fechaActual;
    private $nit;

    // --Parametros Publicos--
    public $id;
    public $placa;
    public $ruta;
    public $material;
    public $nota;
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
            $html .= '<i class="fal fa-info-circle"></i> Registros</h1>';
            $html .= '<button type="button" class="btn btn-info active" onclick="showModalRegistro();">Agregar <i class="fal fa-plus-square"></i></button>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        } else {

            $html = "";
            $html .= '<h1 class="subheader-title">';
            $html .= '<i class="fal fa-info-circle"></i> Registros</h1>';
            $html .= '<h3>No tienes permisos de escritura para este modulo.</h3>';

            echo json_encode(array('status' => NULL, 'data' => $html));
        }
    }

    // -- ⊡ Funcion para crear un registro ⊡ --
    public function createRegistro(): void
    {
        // --Preparamos la consulta--
        $query = "INSERT INTO $this->tableName SET idVehiculo=?, idRuta=?, idMaterial=?, nota=?, datecreated=?, idUsuario=?, nit=? ;";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->placa = htmlspecialchars(strip_tags($this->placa));
        $this->ruta = htmlspecialchars(strip_tags($this->ruta));
        $this->material = htmlspecialchars(strip_tags($this->material));
        $this->nota = htmlspecialchars(strip_tags($this->nota));
        $this->fechaActual = Utilidades::getFecha();
        $this->idUser = $_SESSION['id'];
        $this->nit = $_SESSION['nit'];

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->placa);
        $stmt->bindParam(2, $this->ruta);
        $stmt->bindParam(3, $this->material);
        $stmt->bindParam(4, $this->nota);
        $stmt->bindParam(5, $this->fechaActual);
        $stmt->bindParam(6, $this->idUser);
        $stmt->bindParam(7, $this->nit);

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
            $searchQuery = " AND (nota LIKE :nota)";
            $searchArray = array(
                'nota' => "%$searchValue%",
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
        $stmt = $this->conn->prepare("SELECT 
                                      r.id, v.placa, (ru.nombre)ruta, (m.nombre)material, r.nota, 
                                      (r.datecreated)creado, (r.dateupdate)actualizado, (u.nombres)usuario, r.status 
                                      FROM $this->tableName r 
                                      JOIN $this->tablePlaca v ON r.idVehiculo = v.id
                                      JOIN $this->tableRuta ru ON r.idRuta = ru.id
                                      JOIN $this->tableMaterial m ON r.idMaterial = m.id
                                      JOIN $this->tableUser u ON r.idUsuario = u.id
                                      WHERE 1 $searchQuery 
                                      AND r.status in(1, 2) ORDER BY $columnName $columnSortOrder LIMIT :limit,:offset ");
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
                $botones .= "<button type='button' class='btn btn-primary text-white' data-toggle='tooltip' data-placement='top' title='Agregar Descontables' onclick='agregarDescontable(" . $row['id'] . ");'>";
                $botones .= "<i class='fal fa-file-invoice-dollar'></i></button>";
            }
            if ($datos->d === 1) {
                $botones .= "<button type='button' class='btn btn-danger text-white' data-toggle='tooltip' data-placement='top' title='Eliminar Registro' onclick='eliminarRegistro(" . $row['id'] . ");'>";
                $botones .= "<i class='fal fa-trash'></i></button>";
            }
            $botones .= "</div>";

            $data[] = array(
                "id" => $row['id'],
                "placa" => $row['placa'],
                "ruta" => $row['ruta'],
                "material" => $row['material'],
                "nota" => $row['nota'],
                "creado" => $row['creado'],
                "actualizado" => $row['actualizado'],
                "usuario" => $row['usuario'],
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
        $query = "SELECT id, idVehiculo, idRuta, idMaterial, nota FROM $this->tableName WHERE id=? ;";
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
                    'placa' => $data->idVehiculo,
                    'ruta' => $data->idRuta,
                    'material' => $data->idMaterial,
                    'nota' => $data->nota
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
    public function updateRegistro(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE $this->tableName SET idVehiculo=?, idRuta=?, idMaterial=?, nota=?, dateupdate=?, idUsuario=?, nit=? WHERE id=? ;";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->placa = htmlspecialchars(strip_tags($this->placa));
        $this->ruta = htmlspecialchars(strip_tags($this->ruta));
        $this->material = htmlspecialchars(strip_tags($this->material));
        $this->nota = htmlspecialchars(strip_tags($this->nota));
        $this->fechaActual = Utilidades::getFecha();
        $this->idUser = $_SESSION['id'];
        $this->nit = $_SESSION['nit'];

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->placa);
        $stmt->bindParam(2, $this->ruta);
        $stmt->bindParam(3, $this->material);
        $stmt->bindParam(4, $this->nota);
        $stmt->bindParam(5, $this->fechaActual);
        $stmt->bindParam(6, $this->idUser);
        $stmt->bindParam(7, $this->nit);
        $stmt->bindParam(8, $this->id);

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
}
