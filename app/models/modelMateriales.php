<?php

declare(strict_types=1);

class Material
{
    // --Parametros Privados--
    private $conn;
    private $tableName = "materiales";

    // --Parametros Publicos--
    public $id;
    public $nombre;
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

    // -- ⊡ Funcion para crear un material ⊡ --
    public function createMaterial(): void
    {
        // --Preparamos la consulta--
        $query = "INSERT INTO $this->tableName SET nombre=?, descripcion=?";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->nombre);
        $stmt->bindParam(2, $this->descripcion);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para dataTables Serverside ⊡ --
    public function readAllDaTableMateriales(): void
    {
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
                            descripcion LIKE :descripcion OR
                            status LIKE :status )";
            $searchArray = array(
                'id' => "%$searchValue%",
                'nombre' => "%$searchValue%",
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
        $stmt = $this->conn->prepare("SELECT id, nombre, descripcion, status FROM " . $this->tableName . " WHERE 1 " . $searchQuery . " AND status in(1, 2) ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset ");
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
            $data[] = array(
                "id" => $row['id'],
                "nombre" => $row['nombre'],
                "descripcion" => $row['descripcion'],
                "status" => $estado,
                "defaultContent" => "
                                    <div class='btn-group'>
                                        <button type='button' class='btn btn-success text-white' data-toggle='tooltip' data-placement='top' title='Editar Rol' onclick='editarRegistro(" . $row['id'] . ");'>
                                            <i class='fal fa-edit'></i>
                                        </button>
                                        <button type='button' class='btn btn-danger text-white' data-toggle='tooltip' data-placement='top' title='Eliminar Rol' onclick='eliminarRegistro(" . $row['id'] . ");'>
                                            <i class='fal fa-trash'></i>
                                        </button>
                                        <button type='button' class='btn btn-" . $statusColor . " text-white' data-toggle='tooltip' data-placement='top' title='Estado del Rol' onclick='statusRegistro(" . $row['id'] . ", " . $row['status'] . ");'>
                                            <i class='fal fa-eye'></i>
                                        </button>
                                    </div>"
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
    public function statusMaterial(): void
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
    public function dataMaterial(): void
    {
        // --Preparamos la consulta--
        $query = "SELECT id, nombre, descripcion FROM $this->tableName WHERE id=? ;";
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
                    'descripcion' => $data->descripcion,
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
    public function updateMaterial(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE $this->tableName SET nombre=?, descripcion=? WHERE id=?";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->nombre);
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
