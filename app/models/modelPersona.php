<?php

declare(strict_types=1);

class Persona
{
    // --Parametros Privados--
    private $conn;
    private $tableName = "persona";

    // --Parametros Publicos--
    public $identificacion;
    public $nombres;
    public $a_paterno;
    public $a_materno;
    public $telefono;
    public $email_user;
    public $pswd;
    public $ruc;
    public $nombrefiscal;
    public $direccionfiscal;
    public $rolid;
    public $datecreated;
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

    public function createPersona(): void
    {
        // --Preparamos la consulta--
        $query = "INSERT INTO " . $this->tableName . " SET identificacion=?, nombres=?, a_paterno=?, a_materno=?, telefono=?, email_user=?, pswd=?,
        ruc=?, nombrefiscal=?, direccionfiscal=?, rolid=?, datecreated=?, status=?";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->identificacion = htmlspecialchars(strip_tags($this->identificacion));
        $this->nombres = htmlspecialchars(strip_tags($this->nombres));
        $this->a_paterno = htmlspecialchars(strip_tags($this->a_paterno));
        $this->a_materno = htmlspecialchars(strip_tags($this->a_materno));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->email_user = htmlspecialchars(strip_tags($this->email_user));
        $this->pswd = htmlspecialchars(strip_tags($this->pswd));
        $this->ruc = htmlspecialchars(strip_tags($this->ruc));
        $this->nombrefiscal = htmlspecialchars(strip_tags($this->nombrefiscal));
        $this->direccionfiscal = htmlspecialchars(strip_tags($this->direccionfiscal));
        $this->rolid = htmlspecialchars(strip_tags($this->rolid));
        $this->datecreated = htmlspecialchars(strip_tags($this->datecreated));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->identificacion);
        $stmt->bindParam(2, $this->nombres);
        $stmt->bindParam(3, $this->a_paterno);
        $stmt->bindParam(4, $this->a_materno);
        $stmt->bindParam(5, $this->telefono);
        $stmt->bindParam(6, $this->email_user);
        $stmt->bindParam(7, $this->pswd);
        $stmt->bindParam(8, $this->ruc);
        $stmt->bindParam(9, $this->nombrefiscal);
        $stmt->bindParam(10, $this->direccionfiscal);
        $stmt->bindParam(11, $this->rolid);
        $stmt->bindParam(12, $this->datecreated);
        $stmt->bindParam(13, $this->status);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'message' => 'Usuario Creado Exitosamente'));
        } else {
            echo json_encode(array('status' => '0', 'data' => 'Hubo un error'));
        }
    }


    public function updatePersona(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE " . $this->tableName . " SET identificacion=?, nombres=?, a_paterno=?, a_materno=?, telefono=?, email_user=?, pswd=?,
        ruc=?, nombrefiscal=?, direccionfiscal=?, rolid=?, datecreated=?, status=? WHERE id=?";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->identificacion = htmlspecialchars(strip_tags($this->identificacion));
        $this->nombres = htmlspecialchars(strip_tags($this->nombres));
        $this->a_paterno = htmlspecialchars(strip_tags($this->a_paterno));
        $this->a_materno = htmlspecialchars(strip_tags($this->a_materno));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->email_user = htmlspecialchars(strip_tags($this->email_user));
        $this->pswd = htmlspecialchars(strip_tags($this->pswd));
        $this->ruc = htmlspecialchars(strip_tags($this->ruc));
        $this->nombrefiscal = htmlspecialchars(strip_tags($this->nombrefiscal));
        $this->direccionfiscal = htmlspecialchars(strip_tags($this->direccionfiscal));
        $this->rolid = htmlspecialchars(strip_tags($this->rolid));
        $this->datecreated = htmlspecialchars(strip_tags($this->datecreated));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->identificacion);
        $stmt->bindParam(2, $this->nombres);
        $stmt->bindParam(3, $this->a_paterno);
        $stmt->bindParam(4, $this->a_materno);
        $stmt->bindParam(5, $this->telefono);
        $stmt->bindParam(6, $this->email_user);
        $stmt->bindParam(7, $this->pswd);
        $stmt->bindParam(8, $this->ruc);
        $stmt->bindParam(9, $this->nombrefiscal);
        $stmt->bindParam(10, $this->direccionfiscal);
        $stmt->bindParam(11, $this->rolid);
        $stmt->bindParam(12, $this->datecreated);
        $stmt->bindParam(13, $this->status);
        $stmt->bindParam(14, $this->id);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'message' => 'Usuario Actualizado Exitosamente'));
        } else {
            echo json_encode(array('status' => '0', 'data' => 'Hubo un error'));
        }
    }

    public function deletePersona(): void
    {
        // --Preparamos la consulta--
        $query = "DELETE FROM " . $this->tableName . " WHERE id=?";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->id = htmlspecialchars(strip_tags($this->id));

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->id);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            echo json_encode(array('status' => '1', 'message' => 'Usuario Borrado Exitosamente'));
        } else {
            echo json_encode(array('status' => '0', 'data' => 'Hubo un error'));
        }
    }

    public function readAllDaTablePerson(): void
    {
        ## Read value
        $draw = $this->draw = htmlspecialchars(strip_tags($this->draw));
        $row = $this->row = htmlspecialchars(strip_tags($this->row));
        $rowperpage = $this->rowperpage = htmlspecialchars(strip_tags($this->rowperpage));
        $columnIndex = $this->columnIndex = htmlspecialchars(strip_tags($this->columnIndex));
        $columnName = $this->columnName = htmlspecialchars(strip_tags($this->columnName));
        $columnSortOrder = $this->columnSortOrder = htmlspecialchars(strip_tags($this->columnSortOrder));
        $searchValue = $this->searchValue = htmlspecialchars(strip_tags($this->searchValue));
        $searchArray = array();
        ## Search 
        $searchQuery = " ";
        if ($searchValue != '') {
            $searchQuery = " AND (id LIKE :id OR 
                identificacion LIKE :identificacion OR
                nombres LIKE :nombres OR 
                a_paterno LIKE :a_paterno OR
                a_materno LIKE :a_materno OR
                telefono LIKE :telefono OR
                email_user LIKE :email_user OR
                pswd LIKE :pswd OR
                ruc LIKE :ruc OR
                nombrefiscal LIKE :nombrefiscal OR
                direccionfiscal LIKE :direccionfiscal OR
                rolid LIKE :rolid OR
                datecreated LIKE :datecreated OR
                status LIKE :status )";
            $searchArray = array(
                'id' => "%$searchValue%",
                'identificacion' => "%$searchValue%",
                'nombres' => "%$searchValue%",
                'a_paterno' => "%$searchValue%",
                'a_materno' => "%$searchValue%",
                'telefono' => "%$searchValue%",
                'email_user' => "%$searchValue%",
                'pswd' => "%$searchValue%",
                'ruc' => "%$searchValue%",
                'nombrefiscal' => "%$searchValue%",
                'direccionfiscal' => "%$searchValue%",
                'rolid' => "%$searchValue%",
                'datecreated' => "%$searchValue%",
                'status' => "%$searchValue%"
            );
        }
        ## Total number of records without filtering
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS allcount FROM " . $this->tableName . "");
        $stmt->execute();
        $records = $stmt->fetch();
        $totalRecords = $records['allcount'];
        ## Total number of records with filtering
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS allcount FROM " . $this->tableName . " WHERE 1 " . $searchQuery . "");
        $stmt->execute($searchArray);
        $records = $stmt->fetch();
        $totalRecordwithFilter = $records['allcount'];
        ## Fetch records
        $stmt = $this->conn->prepare("SELECT id, identificacion, nombres, a_paterno, a_materno, telefono, email_user, pswd, ruc, nombrefiscal, direccionfiscal, rolid, datecreated, status FROM " . $this->tableName . " WHERE 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset ");
        // Bind values
        foreach ($searchArray as $key => $search) {
            $stmt->bindValue(':' . $key, $search, PDO::PARAM_STR);
        }
        $stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
        $stmt->execute();
        $empRecords = $stmt->fetchAll();
        $data = array();
        foreach ($empRecords as $row) {
            $data[] = array(
                "id" => $row['id'],
                "identificacion" => $row['identificacion'],
                "nombres" => $row['nombres'],
                "apellidos" => $row['a_paterno'].$row['a_materno'],
                "telefono" => $row['telefono'],
                "email_user" => $row['email_user'],
                "ruc" => $row['ruc'],
                "nombrefiscal" => $row['nombrefiscal'],
                "direccionfiscal" => $row['direccionfiscal'],
                "rolid" => $row['rolid'],
                "status" => $row['status'],
                "defaultContent" => "<div class='btn-group'><button class='btn btn-success'><i class='fa-regular fa-pen-to-square'></i></button><button type='button' class='btn btn-danger'><i class='fa-regular fa-trash-can'></i></button></div>"
            );
        }
        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );
        echo json_encode($response);
    }
}
