<?php

declare(strict_types=1);

include_once(LIBRARIES . 'sesion.php');

class Login
{
    // --Parametros Privados--
    private $conn;
    private $tableName = "usuarios";
    private $tableEmpresa = "empresas";

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
        $query = "SELECT 
                  u.id, u.nit, (e.nombre)empresa, u.nombres, u.email_user, u.content_type, u.base_64, u.rolid, (u.status)sUser, (e.status)sEmpre
                  FROM $this->tableName u
                  JOIN $this->tableEmpresa e ON u.nit = e.nit
                  WHERE u.email_user=? AND u.pswd=? ;";
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

                if ($data->sUser === 1) {

                    if ($data->sEmpre === 1) {
                        // -- ↓↓ Creamos la sesion y le pasamos todos los datos del usuario ↓↓ --
                        $datosSesion = array(
                            'id' => $data->id,
                            'nit' => $data->nit,
                            'empresa' => $data->empresa,
                            'usuario' => $data->nombres,
                            'email' => $data->email_user,
                            'imagenUser' => 'data: ' . $data->content_type . ';base64,' . $data->base_64,
                            'rol' => $data->rolid,
                            'token' => "dqtQS2cBmGd8MbyMCHBj3Dq38Xm89vVyxxum4aySt9witAwBN9",
                        );
                        SesionTools::crearSesion($datosSesion);
                        // -- ↓↓ Retornamos las respuestas con la urldefault ↓↓ --
                        echo json_encode(array('status' => '1', 'data' => NULL, 'url' => Roots::inicioSesion()));
                    } else {
                        // -- ↓↓ Empresa inactiva ↓↓ --
                        echo json_encode(array('status' => '9', 'data' => NULL));
                    }
                } else {
                    // -- ↓↓ Usuario inactivo ↓↓ --
                    echo json_encode(array('status' => '8', 'data' => NULL));
                }
            } else {
                // -- ↓↓ Usuario no encontrado ↓↓ --
                echo json_encode(array('status' => '3', 'data' => NULL));
            }
        } else {
            // -- ↓↓ Falla en la ejecución de la consulta ↓↓ --
            echo json_encode(array('status' => '0', 'data' => NULL));
        }
    }
}
