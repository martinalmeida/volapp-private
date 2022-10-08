<?php

declare(strict_types=1);

class Persona {
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
    public $password;
    public $ruc;
    public $nombrefiscal;
    public $direccionfiscal;
    public $rolid;
    public $datecreated;
    public $status;
    public $id;


    // --Constructor para la conexion de la BD--
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createPersona(): void 
    {
        // --Preparamos la consulta--
        $query = "INSERT INTO ".$this->tableName." SET identificacion=?, nombres=?, a_paterno=?, a_materno=?, telefono=?, email_user=?, password=?,
        ruc=?, nombrefiscal=?, direccionfiscal=?, rolid=?, datecreated=?, status=?";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->identificacion=htmlspecialchars(strip_tags($this->identificacion));
        $this->nombres=htmlspecialchars(strip_tags($this->nombres));
        $this->a_paterno=htmlspecialchars(strip_tags($this->a_paterno));
        $this->a_materno=htmlspecialchars(strip_tags($this->a_materno));
        $this->telefono=htmlspecialchars(strip_tags($this->telefono));
        $this->email_user=htmlspecialchars(strip_tags($this->email_user));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->ruc=htmlspecialchars(strip_tags($this->ruc));
        $this->nombrefiscal=htmlspecialchars(strip_tags($this->nombrefiscal));
        $this->direccionfiscal=htmlspecialchars(strip_tags($this->direccionfiscal));
        $this->rolid=htmlspecialchars(strip_tags($this->rolid));
        $this->datecreated=htmlspecialchars(strip_tags($this->datecreated));
        $this->status=htmlspecialchars(strip_tags($this->status));

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->identificacion);
        $stmt->bindParam(2, $this->nombres);
        $stmt->bindParam(3, $this->a_paterno);
        $stmt->bindParam(4, $this->a_materno);
        $stmt->bindParam(5, $this->telefono);
        $stmt->bindParam(6, $this->email_user);
        $stmt->bindParam(7, $this->password);
        $stmt->bindParam(8, $this->ruc);
        $stmt->bindParam(9, $this->nombrefiscal);
        $stmt->bindParam(10, $this->direccionfiscal);
        $stmt->bindParam(11, $this->rolid);
        $stmt->bindParam(12, $this->datecreated);
        $stmt->bindParam(13, $this->status);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            if ($stmt->rowCount() >= 1) {
                echo json_encode(array('status' => '1', 'message' => 'Usuario Creado Exitosamente'));
            } else {
                echo json_encode(array('status' => '3', 'message' => 'Hubo un error al crear el usuario'));
            }
        } else {
            echo json_encode(array('status' => '0', 'data' => 'Hubo un error'));
        }

    }


    public function updatePersona(): void
    {
        // --Preparamos la consulta--
        $query = "UPDATE ".$this->tableName." SET identificacion=?, nombres=?, a_paterno=?, a_materno=?, telefono=?, email_user=?, password=?,
        ruc=?, nombrefiscal=?, direccionfiscal=?, rolid=?, datecreated=?, status=? WHERE id=?";
        $stmt = $this->conn->prepare($query);

        // --Escapamos los caracteres--
        $this->identificacion=htmlspecialchars(strip_tags($this->identificacion));
        $this->nombres=htmlspecialchars(strip_tags($this->nombres));
        $this->a_paterno=htmlspecialchars(strip_tags($this->a_paterno));
        $this->a_materno=htmlspecialchars(strip_tags($this->a_materno));
        $this->telefono=htmlspecialchars(strip_tags($this->telefono));
        $this->email_user=htmlspecialchars(strip_tags($this->email_user));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->ruc=htmlspecialchars(strip_tags($this->ruc));
        $this->nombrefiscal=htmlspecialchars(strip_tags($this->nombrefiscal));
        $this->direccionfiscal=htmlspecialchars(strip_tags($this->direccionfiscal));
        $this->rolid=htmlspecialchars(strip_tags($this->rolid));
        $this->datecreated=htmlspecialchars(strip_tags($this->datecreated));
        $this->status=htmlspecialchars(strip_tags($this->status));
        $this->id=htmlspecialchars(strip_tags($this->id));

        // --Almacenamos los valores--
        $stmt->bindParam(1, $this->identificacion);
        $stmt->bindParam(2, $this->nombres);
        $stmt->bindParam(3, $this->a_paterno);
        $stmt->bindParam(4, $this->a_materno);
        $stmt->bindParam(5, $this->telefono);
        $stmt->bindParam(6, $this->email_user);
        $stmt->bindParam(7, $this->password);
        $stmt->bindParam(8, $this->ruc);
        $stmt->bindParam(9, $this->nombrefiscal);
        $stmt->bindParam(10, $this->direccionfiscal);
        $stmt->bindParam(11, $this->rolid);
        $stmt->bindParam(12, $this->datecreated);
        $stmt->bindParam(13, $this->status);
        $stmt->bindParam(14, $this->id);

        // --Ejecutamos la consulta y validamos ejecucion--
        if ($stmt->execute()) {
            if ($stmt->rowCount() >= 1) {
                echo json_encode(array('status' => '1', 'message' => 'Usuario Actualizado Exitosamente'));
            } else {
                echo json_encode(array('status' => '3', 'message' => 'Hubo un error al Actualizar el usuario'));
            }
        } else {
            echo json_encode(array('status' => '0', 'data' => 'Hubo un error'));
        }

    }
    
}