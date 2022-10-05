<?php

declare(strict_types=1);

include_once($_SERVER['DOCUMENT_ROOT'] . '/volapp/inc/volappConfig.php');
include($_SERVER['DOCUMENT_ROOT'] . LIBRARIES . 'validations.php');
include($_SERVER['DOCUMENT_ROOT'] . MODELS . 'modelLogin.php');

class LoginController
{
    public function getUser(): void
    {
        // --Importacion e inicializacion de conexion--
        include($_SERVER['DOCUMENT_ROOT'] . INC . 'db.php');
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
}
