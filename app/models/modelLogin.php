<?php

declare(strict_types=1);

include_once(LIBRARIES . 'sesion.php');

class Login
{
    // --Parametros Privados--
    private $conn;
    private $tableName = "usuarios";
    private const URLDEFAULT = 'public/views/home/';

    // --Parametros Publicos--
    public $correo;
    public $password;

    // --Constructor para la conexion de la BD--
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // -- ⊡ Funcion para validar el usuario ⊡ --
    public function validatedUser(): void
    {
        // -- ↓↓ Preparamos la consulta ↓↓ --
        $query = "SELECT id, nombres, email_user, content_type, base_64, rolid FROM $this->tableName WHERE email_user=? AND pswd=? AND status = 1 ;";
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
                $data = $stmt->fetch(PDO::FETCH_OBJ);

                // -- ↓↓ Creamos la sesion y le pasamos todos los datos del usuario ↓↓ --
                $datosSesion = array(
                    'id' => $data->id,
                    'usuario' => $data->nombres,
                    'email' => $data->email_user,
                    'imagenUser' => 'data: ' . $data->content_type . ';base64,' . $data->base_64,
                    'rol' => $data->rolid,
                    'token' => "dqtQS2cBmGd8MbyMCHBj3Dq38Xm89vVyxxum4aySt9witAwBN9",
                );
                SesionTools::crearSesion($datosSesion);
                // -- ↓↓ Retornamos las respuestas con la urldefault ↓↓ --
                echo json_encode(array('status' => '1', 'data' => $data, 'url' => self::URLDEFAULT));
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
