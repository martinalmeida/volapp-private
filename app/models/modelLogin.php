<?php

declare(strict_types=1);

class Login
{
    // --Parametros Privados--
    private $conn;
    private $tableName = "persona";

    // --Parametros Publicos--
    public $correo;
    public $password;
    public $data;

    // --Constructor para la conexion de la BD--
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // -- ⊡ Funcion para validar el usuario ⊡ --
    public function validatedUser(): void
    {
        // -- ↓↓ Preparamos la consulta ↓↓ --
        $query = "SELECT idpersona, nombres, email_user,  FROM $this->tableName WHERE email_user=? AND pswd=? AND status = 1 ;";
        $stmt = $this->conn->prepare($query);

        // -- ↓↓ Escapamos los caracteres ↓↓ --
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        $this->password = htmlspecialchars(strip_tags($this->password));

        // -- ↓↓ Almacenamos los valores ↓↓ --
        $stmt->bindParam(1, $this->correo);
        $stmt->bindParam(2, $this->password);

        // -- ↓↓ Ejecutamos la consulta y validamos ejecucion ↓↓ --
        if ($stmt->execute()) {

            // -- ↓↓ Comprobamos que venga algun dato ↓↓ --
            if ($stmt->rowCount() >= 1) {

                // -- ↓↓ Usuario encontrado y activo ↓↓ --
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                var_dump($data);
                exit;
                echo json_encode(array('status' => '1', 'data' => $data));
            } else {
                // -- ↓↓ Usuario no encontrado o inactivo ↓↓ --
                echo json_encode(array('status' => '3', 'data' => NULL));
            }
        } else {
            // -- ↓↓ Falla en la ejecución de la consulta ↓↓ --
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }

    // -- ⊡ Funcion para traer el rol y los permisos del usuario ⊡ --
    public function permisosUsuario(): void
    {
        // -- ↓↓ Preparamos la consulta ↓↓ --
        $query = "SELECT * FROM $this->tableName WHERE p.email_user=? AND p.pswd=? AND p.status = 1 ;";
        $stmt = $this->conn->prepare($query);

        // -- ↓↓ Escapamos los caracteres ↓↓ --
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        $this->password = htmlspecialchars(strip_tags($this->password));

        // -- ↓↓ Almacenamos los valores ↓↓ --
        $stmt->bindParam(1, $this->correo);
        $stmt->bindParam(2, $this->password);

        // -- ↓↓ Ejecutamos la consulta y validamos ejecucion ↓↓ --
        if ($stmt->execute()) {

            // -- ↓↓ Comprobamos que venga algun dato ↓↓ --
            if ($stmt->rowCount() >= 1) {

                // -- ↓↓ Usuario encontrado y activo ↓↓ --
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode(array('status' => '1', 'data' => $data));
            } else {
                // -- ↓↓ Usuario no encontrado o inactivo ↓↓ --
                echo json_encode(array('status' => '3', 'data' => NULL));
            }
        } else {
            // -- ↓↓ Falla en la ejecución de la consulta ↓↓ --
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }
}
