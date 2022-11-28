<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(LIBRARIES . 'utilidades.php');
include(MODELS . 'modelFletes.php');

class FletesController
{
    public function read(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $fletes = new Fletes($db);

        $fletes->getReadPermisos();
    }

    public function write(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $fletes = new Fletes($db);

        $fletes->getWritePermisos();
    }

    public function readAllDaTable(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $fletes = new Fletes($db);

        $fletes->draw = htmlspecialchars($_POST['draw']);
        $fletes->row = htmlspecialchars($_POST['start']);
        $fletes->rowperpage = htmlspecialchars($_POST['length']);
        $fletes->columnIndex = htmlspecialchars($_POST['order'][0]['column']);
        $fletes->columnName = htmlspecialchars($_POST['columns'][$fletes->columnIndex]['data']);
        $fletes->columnSortOrder = htmlspecialchars($_POST['order'][0]['dir']);
        $fletes->searchValue = htmlspecialchars($_POST['search']['value']);

        $fletes->readAllDaTableAlquiler();
    }

    public function status(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $fletes = new Fletes($db);

        // --Seteo de valores existentes en el POST--
        $fletes->id = isset($_POST['idAlquiler']) ? strtoupper(trim($_POST['idAlquiler'])) : NULL;
        $fletes->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        if (Validar::numeros($fletes->id) && Validar::numeros($fletes->status)) {
            $fletes->statusAlquiler();
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
        $fletes = new Fletes($db);

        // --Seteo de valores existentes en el POST--
        $fletes->id = isset($_POST['idAlquiler']) ? strtoupper(trim($_POST['idAlquiler'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($fletes->id)) {
            $fletes->datAlquiler();
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
        $fletes = new Fletes($db);

        // --Seteo de valores existentes en el POST--
        $fletes->id = isset($_POST['idAlquiler']) ? trim($_POST['idAlquiler']) : NULL;
        $fletes->ruta = isset($_POST['ruta']) ? trim($_POST['ruta']) : NULL;
        $fletes->standBy = isset($_POST['standBy']) ? trim($_POST['standBy']) : NULL;
        $fletes->tarifaHora = isset($_POST['tarifaHora']) ? strtoupper(trim($_POST['tarifaHora'])) : NULL;

        // --No se adjunta un archivo nuevo--
        if (
            Validar::numeros($fletes->id) && Validar::float($fletes->ruta, '.') &&
            Validar::float($fletes->standBy, '.') && Validar::float($fletes->tarifaHora, '.')
        ) {
            $fletes->parametrizacionAlquiler();
        } else {
            // --Error de validación--
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
