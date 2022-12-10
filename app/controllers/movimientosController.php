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

    public function create(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $movimientos = new Movimientos($db);

        // --Seteo de valores existentes en el POST--
        $movimientos->placa = isset($_POST['placaInsert']) ? strtoupper(trim($_POST['placaInsert'])) : NULL;
        $movimientos->ruta = isset($_POST['rutaInsert']) ? strtoupper(trim($_POST['rutaInsert'])) : NULL;
        $movimientos->kilometraje = isset($_POST['kilometrajeInsert']) ? strtoupper(trim($_POST['kilometrajeInsert'])) : NULL;
        $movimientos->tarifa = isset($_POST['tarifaInsert']) ? strtoupper(trim($_POST['tarifaInsert'])) : NULL;

        if (
            Validar::numeros($movimientos->placa) && Validar::numeros($movimientos->ruta) &&
            Validar::float($movimientos->kilometraje, '.') && Validar::float($movimientos->tarifa, '.')
        ) {
            $movimientos->createAcuerdo();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
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

        $movimientos->readAllDaTableMovimiento();
    }

    public function status(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $movimientos = new Movimientos($db);

        // --Seteo de valores existentes en el POST--
        $movimientos->id = isset($_POST['idMovimiento']) ? strtoupper(trim($_POST['idMovimiento'])) : NULL;
        $movimientos->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        if (Validar::numeros($movimientos->id) && Validar::numeros($movimientos->status)) {
            $movimientos->statusMovimiento();
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
        $movimientos->id = isset($_POST['idMovimiento']) ? strtoupper(trim($_POST['idMovimiento'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($movimientos->id)) {
            $movimientos->dataMovimiento();
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
        $movimientos->id = isset($_POST['idMovimiento']) ? trim($_POST['idMovimiento']) : NULL;
        $movimientos->ruta = isset($_POST['ruta']) ? trim($_POST['ruta']) : NULL;
        $movimientos->kilometraje = isset($_POST['kilometraje']) ? trim($_POST['kilometraje']) : NULL;
        $movimientos->tarifa = isset($_POST['tarifa']) ? strtoupper(trim($_POST['tarifa'])) : NULL;

        // --No se adjunta un archivo nuevo--
        if (
            Validar::numeros($movimientos->id) && Validar::numeros($movimientos->ruta) &&
            Validar::numeros($movimientos->kilometraje) && Validar::numeros($movimientos->tarifa)
        ) {
            $movimientos->parametrizacionMovimiento();
        } else {
            // --Error de validación--
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
