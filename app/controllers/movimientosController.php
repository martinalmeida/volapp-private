<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(LIBRARIES . 'utilidades.php');
include(MODELS . 'modelMovimientos.php');

class MovimientosController
{
    public function read(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $movimientos = new Movimientos($db);

        $movimientos->getReadPermisos();
    }

    public function write(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $movimientos = new Movimientos($db);

        $movimientos->getWritePermisos();
    }

    public function readAllDaTable(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $movimientos = new Movimientos($db);

        $movimientos->draw = htmlspecialchars($_POST['draw']);
        $movimientos->row = htmlspecialchars($_POST['start']);
        $movimientos->rowperpage = htmlspecialchars($_POST['length']);
        $movimientos->columnIndex = htmlspecialchars($_POST['order'][0]['column']);
        $movimientos->columnName = htmlspecialchars($_POST['columns'][$movimientos->columnIndex]['data']);
        $movimientos->columnSortOrder = htmlspecialchars($_POST['order'][0]['dir']);
        $movimientos->searchValue = htmlspecialchars($_POST['search']['value']);

        $movimientos->readAllDaTableAlquiler();
    }

    public function status(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $movimientos = new Movimientos($db);

        // --Seteo de valores existentes en el POST--
        $movimientos->id = isset($_POST['idAlquiler']) ? strtoupper(trim($_POST['idAlquiler'])) : NULL;
        $movimientos->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        if (Validar::numeros($movimientos->id) && Validar::numeros($movimientos->status)) {
            $movimientos->statusAlquiler();
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
        $movimientos = new Movimientos($db);

        // --Seteo de valores existentes en el POST--
        $movimientos->id = isset($_POST['idAlquiler']) ? strtoupper(trim($_POST['idAlquiler'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($movimientos->id)) {
            $movimientos->datAlquiler();
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
        $movimientos = new Movimientos($db);

        // --Seteo de valores existentes en el POST--
        $movimientos->id = isset($_POST['idAlquiler']) ? trim($_POST['idAlquiler']) : NULL;
        $movimientos->ruta = isset($_POST['ruta']) ? trim($_POST['ruta']) : NULL;
        $movimientos->standBy = isset($_POST['standBy']) ? trim($_POST['standBy']) : NULL;
        $movimientos->tarifaHora = isset($_POST['tarifaHora']) ? strtoupper(trim($_POST['tarifaHora'])) : NULL;

        // --No se adjunta un archivo nuevo--
        if (
            Validar::numeros($movimientos->id) && Validar::float($movimientos->ruta, '.') &&
            Validar::float($movimientos->standBy, '.') && Validar::float($movimientos->tarifaHora, '.')
        ) {
            $movimientos->parametrizacionAlquiler();
        } else {
            // --Error de validación--
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
