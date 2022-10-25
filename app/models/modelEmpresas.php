<?php

declare(strict_types=1);

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

    public function createEmpresa(): void
    {
        // --Preparamos la consulta--
        $query = "INSERT INTO  $this->tableName SET nit=?, digito=?, nombre=?, representante=?, telefono=?, direccion=?, correo=?,
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

    public function readAllDaTableEmpresa(): void
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
            $searchQuery = " AND (nit LIKE :nit OR 
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
                'nombre' => "%$searchValue%",
                'representante' => "%$searchValue%",
                'telefono' => "%$searchValue%",
                'direccion' => "%$searchValue%",
                'correo' => "%$searchValue%",
                'pais' => "%$searchValue%",
                'ciudad' => "%$searchValue%",
                'contacto' => "%$searchValue%",
                'emailTec' => "%$searchValue%",
                'emaiLogis' => "%$searchValue%",
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
        $stmt = $this->conn->prepare("SELECT (nit)nitId, concat(nit,' - ',digito)nit, nombre, representante, telefono, direccion, correo, pais, ciudad, contacto, email_tec, email_logis, status FROM " . $this->tableName . " WHERE 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset ");
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
                "nit" => $row['nit'],
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
                "defaultContent" => "
                                    <div class='btn-group'>
                                        <button type='button' class='btn btn-success text-white' data-toggle='tooltip' data-placement='top' title='Editar Empresa' onclick='editarRegistro(" . $row['nitId'] . ");'>
                                            <i class='fa-regular fa-pen-to-square'></i>
                                        </button>
                                        <button type='button' class='btn btn-danger text-white' data-toggle='tooltip' data-placement='top' title='Eliminar Empresa' onclick='eliminarRegistro(" . $row['nitId'] . ");'>
                                            <i class='fa-regular fa-trash-can'></i>
                                        </button>
                                        <button type='button' class='btn btn-" . $statusColor . " text-white' data-toggle='tooltip' data-placement='top' title='Estado de la Empresa' onclick='statusRegistro(" . $row['nitId'] . ", " . $row['status'] . ");'>
                                            <i class='fa-regular fa-eye'></i></button>
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

    public function statusEmpresa(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE " . $this->tableName . " SET status =? WHERE nit=?";
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


    // public function updatePersona(): void
    // {
    //     // --Preparamos la consulta--
    //     $query = "UPDATE " . $this->tableName . " SET identificacion=?, nombres=?, a_paterno=?, a_materno=?, telefono=?, email_user=?, pswd=?,
    //     ruc=?, nombrefiscal=?, direccionfiscal=?, rolid=?, datecreated=?, status=? WHERE id=?";
    //     $stmt = $this->conn->prepare($query);

    //     // --Escapamos los caracteres--
    //     $this->identificacion = htmlspecialchars(strip_tags($this->identificacion));
    //     $this->nombres = htmlspecialchars(strip_tags($this->nombres));
    //     $this->a_paterno = htmlspecialchars(strip_tags($this->a_paterno));
    //     $this->a_materno = htmlspecialchars(strip_tags($this->a_materno));
    //     $this->telefono = htmlspecialchars(strip_tags($this->telefono));
    //     $this->email_user = htmlspecialchars(strip_tags($this->email_user));
    //     $this->pswd = htmlspecialchars(strip_tags($this->pswd));
    //     $this->ruc = htmlspecialchars(strip_tags($this->ruc));
    //     $this->nombrefiscal = htmlspecialchars(strip_tags($this->nombrefiscal));
    //     $this->direccionfiscal = htmlspecialchars(strip_tags($this->direccionfiscal));
    //     $this->rolid = htmlspecialchars(strip_tags($this->rolid));
    //     $this->datecreated = htmlspecialchars(strip_tags($this->datecreated));
    //     $this->status = htmlspecialchars(strip_tags($this->status));
    //     $this->id = htmlspecialchars(strip_tags($this->id));

    //     // --Almacenamos los valores--
    //     $stmt->bindParam(1, $this->identificacion);
    //     $stmt->bindParam(2, $this->nombres);
    //     $stmt->bindParam(3, $this->a_paterno);
    //     $stmt->bindParam(4, $this->a_materno);
    //     $stmt->bindParam(5, $this->telefono);
    //     $stmt->bindParam(6, $this->email_user);
    //     $stmt->bindParam(7, $this->pswd);
    //     $stmt->bindParam(8, $this->ruc);
    //     $stmt->bindParam(9, $this->nombrefiscal);
    //     $stmt->bindParam(10, $this->direccionfiscal);
    //     $stmt->bindParam(11, $this->rolid);
    //     $stmt->bindParam(12, $this->datecreated);
    //     $stmt->bindParam(13, $this->status);
    //     $stmt->bindParam(14, $this->id);

    //     // --Ejecutamos la consulta y validamos ejecucion--
    //     if ($stmt->execute()) {
    //         echo json_encode(array('status' => '1', 'message' => 'Usuario Actualizado Exitosamente'));
    //     } else {
    //         echo json_encode(array('status' => '0', 'data' => 'Hubo un error'));
    //     }
    // }

    // public function deletePersona(): void
    // {
    //     // --Preparamos la consulta--
    //     $query = "DELETE FROM " . $this->tableName . " WHERE id=?";
    //     $stmt = $this->conn->prepare($query);

    //     // --Escapamos los caracteres--
    //     $this->id = htmlspecialchars(strip_tags($this->id));

    //     // --Almacenamos los valores--
    //     $stmt->bindParam(1, $this->id);

    //     // --Ejecutamos la consulta y validamos ejecucion--
    //     if ($stmt->execute()) {
    //         echo json_encode(array('status' => '1', 'message' => 'Usuario Borrado Exitosamente'));
    //     } else {
    //         echo json_encode(array('status' => '0', 'data' => 'Hubo un error'));
    //     }
    // }

}
