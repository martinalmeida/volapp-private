<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(LIBRARIES . 'utilidades.php');
include(MODELS . 'modelAlquiler.php');

class AlquilerController
{
    public function read(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $alquiler = new Alquiler($db);

        $alquiler->getReadPermisos();
    }

    public function write(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $alquiler = new Alquiler($db);

        $alquiler->getWritePermisos();
    }

    public function readAllDaTable(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $alquiler = new Alquiler($db);

        $alquiler->draw = htmlspecialchars($_POST['draw']);
        $alquiler->row = htmlspecialchars($_POST['start']);
        $alquiler->rowperpage = htmlspecialchars($_POST['length']);
        $alquiler->columnIndex = htmlspecialchars($_POST['order'][0]['column']);
        $alquiler->columnName = htmlspecialchars($_POST['columns'][$alquiler->columnIndex]['data']);
        $alquiler->columnSortOrder = htmlspecialchars($_POST['order'][0]['dir']);
        $alquiler->searchValue = htmlspecialchars($_POST['search']['value']);

        $alquiler->readAllDaTableAlquiler();
    }

    public function status(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $alquiler = new Alquiler($db);

        // --Seteo de valores existentes en el POST--
        $alquiler->id = isset($_POST['idAlquiler']) ? strtoupper(trim($_POST['idAlquiler'])) : NULL;
        $alquiler->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        if (Validar::numeros($alquiler->id) && Validar::numeros($alquiler->status)) {
            $alquiler->statusAlquiler();
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
        $alquiler = new Alquiler($db);

        // --Seteo de valores existentes en el POST--
        $alquiler->id = isset($_POST['idAlquiler']) ? strtoupper(trim($_POST['idAlquiler'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($alquiler->id)) {
            $alquiler->datAlquiler();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }

    public function parametrizar(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $alquiler = new Alquiler($db);

        // --Seteo de valores existentes en el POST--
        $alquiler->id = isset($_POST['idAlquiler']) ? trim($_POST['idAlquiler']) : NULL;
        $alquiler->ruta = isset($_POST['ruta']) ? trim($_POST['ruta']) : NULL;
        $alquiler->standBy = isset($_POST['standBy']) ? trim($_POST['standBy']) : NULL;
        $alquiler->tarifaHora = isset($_POST['tarifaHora']) ? strtoupper(trim($_POST['tarifaHora'])) : NULL;

        // --No se adjunta un archivo nuevo--
        if (
            Validar::numeros($alquiler->id) && Validar::float($alquiler->ruta, '.') &&
            Validar::float($alquiler->standBy, '.') && Validar::float($alquiler->tarifaHora, '.')
        ) {
            $alquiler->parametrizacionAlquiler();
        } else {
            // --Error de validación--
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
