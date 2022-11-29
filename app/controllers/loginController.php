<?php

declare(strict_types=1);
header('Content-type: application/json');

include_once(LIBRARIES . 'validations.php');
include_once(MODELS . 'modelLogin.php');
include_once(ROOTS);

class LoginController
{
    public function getUser(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $login = new Login($db);

        // --Seteo de valores existentes en el POST--
        $login->correo = isset($_POST['usuarioLogin']) ? strtoupper(trim($_POST['usuarioLogin'])) : NULL;
        $login->password = isset($_POST['contraseniaLogin']) ? strtoupper(trim($_POST['contraseniaLogin'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (validar::correo($login->correo) && validar::password($login->password)) {
            $login->validatedUser();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }

    public function logout(): void
    {
        // --Validacion de cerrar sesion--
        if (SesionTools::cerrarsesion()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
