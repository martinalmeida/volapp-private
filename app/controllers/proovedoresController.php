<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(MODELS . 'modelProovedores.php');


class ProovedoresController
{
    public function read(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $proovedor = new Proovedores($db);

        $proovedor->getReadPermisos();
    }

    public function getRuta(): void
    {
        include_once(ROOTS);
        // --Seteo de valores existentes en el POST--
        $numero = isset($_POST['idRuta']) ? strtoupper(trim($_POST['idRuta'])) : NULL;

        if (Validar::numeros($numero)) {
            echo json_encode(array('status' => '1', 'data' => NULL, 'url' => Roots::proovedoresRoots($numero)));
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL, 'url' => NULL));
        }
    }
}
