<?php

declare(strict_types=1);

include_once(LIBRARIES . 'sesion.php');

class Login
{
    // --Parametros Privados--
    private $conn;
    private $tableName = "persona";
    private $tableRol = "rol";
    private $tablePermisos = "permisos";
    private $tableModulo = "modulo";
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
        $query = "SELECT id, nombres, email_user, content_type, base_64 FROM $this->tableName WHERE email_user=? AND pswd=? AND status = 1 ;";
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

                // -- ↓↓ Traemos los permisos ↓↓ --
                $permisos = self::permisosUsuario($data->id);
                // -- ↓↓ Creamos la sesion y le pasamos todos los datos del usuario ↓↓ --
                $datosSesion = array(
                    'id' => $data->id,
                    'usuario' => $data->nombres,
                    'email' => $data->email_user,
                    'permisos' => $permisos,
                    'content' => $data->content_type,
                    'base64' => $data->base_64,
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

    // -- ⊡ Funcion para traer el rol, permisos y url del modulo ⊡ --
    private function permisosUsuario($id)
    {
        // -- ↓↓ Preparamos la consulta ↓↓ --
        $query = "SELECT 
                  (p2.rolid)rol, (p2.moduloid)id, (m.menu_id)idsubmodulo, (m.titulo)modulo, m.icono, (m.page)pagina, p2.r, p2.w, p2.u, p2.d
                  FROM $this->tableName p 
                  JOIN $this->tableRol r ON p.rolid = r.id 
                  JOIN $this->tablePermisos p2 ON p2.rolid = r.id 
                  JOIN $this->tableModulo m ON p2.moduloid = m.id
                  WHERE m.status = 1
                  AND p.id = ?; ";
        $stmt = $this->conn->prepare($query);

        // -- ↓↓ Preparamos arreglo de permisos que retornaremos ↓↓ --
        $arrayPermisos = array();

        // -- ↓↓ Almacenamos los valores ↓↓ --
        $stmt->bindParam(1, $id);

        // -- ↓↓ Ejecutamos la consulta y validamos ejecucion ↓↓ --
        if ($stmt->execute()) {

            // -- ↓↓ Comprobamos que venga algun dato ↓↓ --
            if ($stmt->rowCount() >= 1) {
                // -- ↓↓ Permisos encontrados ↓↓ --
                $data = $stmt->fetchAll();
                foreach ($data as $row) {
                    $arrayPermisos[] = array(
                        "rol" => $row["rol"],
                        "id" => $row["id"],
                        "idSubmodulo" => $row["idsubmodulo"],
                        "modulo" => $row["modulo"],
                        "icono" => $row["icono"],
                        "pagina" => $row["pagina"],
                        "r" => $row["r"],
                        "w" => $row["w"],
                        "u" => $row["u"],
                        "d" => $row["d"],
                    );
                }
                return $arrayPermisos;
            } else {
                // -- ↓↓ Permisos no encontrados ↓↓ --
                echo json_encode(array('status' => '6', 'data' => NULL));
                exit;
            }
        } else {
            // -- ↓↓ Falla en la ejecución de la consulta ↓↓ --
            print_r($stmt->errorInfo());
        }
    }
}
