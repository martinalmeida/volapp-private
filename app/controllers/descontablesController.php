<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(LIBRARIES . 'utilidades.php');
include(MODELS . 'modelDescontables.php');

class DescontablesController
{
    public function create(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $descontable = new Descontable($db);

        // --Seteo de valores existentes en el POST--
        $descontable->nombre = isset($_POST['nombre']) ? strtoupper(trim($_POST['nombre'])) : NULL;
        $descontable->descripcion = isset($_POST['descripcion']) ? strtoupper(trim($_POST['descripcion'])) : NULL;

        if (Validar::alfanumerico($descontable->nombre) && Validar::alfanumerico($descontable->descripcion)) {
            $descontable->createRuta();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }

    public function getData(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $descontable = new Descontable($db);

        // --Seteo de valores existentes en el POST--
        $descontable->id = isset($_POST['idRegistro']) ? strtoupper(trim($_POST['idRegistro'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($descontable->id)) {
            $descontable->dataRuta();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }

    public function update(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $descontable = new Descontable($db);

        // --Seteo de valores existentes en el POST--
        $descontable->id = isset($_POST['idRegistro']) ? strtoupper(trim($_POST['idRegistro'])) : NULL;
        $descontable->nombre = isset($_POST['nombre']) ? strtoupper(trim($_POST['nombre'])) : NULL;
        $descontable->descripcion = isset($_POST['descripcion']) ? strtoupper(trim($_POST['descripcion'])) : NULL;


        if (Validar::alfanumerico($descontable->nombre) && Validar::alfanumerico($descontable->descripcion)) {
            $descontable->updateRuta();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
