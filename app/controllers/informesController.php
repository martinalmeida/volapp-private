<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(MODELS . 'modelInformesRelacion.php');


class InformesController
{
    public function read(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $informes = new Registro($db);

        $informes->getReadPermisos();
    }

    public function getRuta(): void
    {
        include_once(ROOTS);
        // --Seteo de valores existentes en el POST--
        $numero = isset($_POST['idRuta']) ? strtoupper(trim($_POST['idRuta'])) : NULL;

        if (Validar::numeros($numero)) {
            echo json_encode(array('status' => '1', 'data' => NULL, 'url' => Roots::informesRoots($numero)));
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL, 'url' => NULL));
        }
    }
}
