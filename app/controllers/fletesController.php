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

    public function create(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $fletes = new Fletes($db);

        // --Seteo de valores existentes en el POST--
        $fletes->placa = isset($_POST['placaInsert']) ? strtoupper(trim($_POST['placaInsert'])) : NULL;
        $fletes->ruta = isset($_POST['rutaInsert']) ? strtoupper(trim($_POST['rutaInsert'])) : NULL;
        $fletes->flete = isset($_POST['fleteInsert']) ? strtoupper(trim($_POST['fleteInsert'])) : NULL;

        if (Validar::numeros($fletes->placa) && Validar::numeros($fletes->ruta) && Validar::float($fletes->flete, '.')) {
            $fletes->createAcuerdo();
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
        $fletes = new Fletes($db);

        $fletes->draw = htmlspecialchars($_POST['draw']);
        $fletes->row = htmlspecialchars($_POST['start']);
        $fletes->rowperpage = htmlspecialchars($_POST['length']);
        $fletes->columnIndex = htmlspecialchars($_POST['order'][0]['column']);
        $fletes->columnName = htmlspecialchars($_POST['columns'][$fletes->columnIndex]['data']);
        $fletes->columnSortOrder = htmlspecialchars($_POST['order'][0]['dir']);
        $fletes->searchValue = htmlspecialchars($_POST['search']['value']);

        $fletes->readAllDaTableFletes();
    }

    public function status(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $fletes = new Fletes($db);

        // --Seteo de valores existentes en el POST--
        $fletes->id = isset($_POST['idFlete']) ? strtoupper(trim($_POST['idFlete'])) : NULL;
        $fletes->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        if (Validar::numeros($fletes->id) && Validar::numeros($fletes->status)) {
            $fletes->statusFlete();
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
        $fletes->id = isset($_POST['idFlete']) ? strtoupper(trim($_POST['idFlete'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($fletes->id)) {
            $fletes->dataFletes();
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
        $fletes->id = isset($_POST['idFlete']) ? trim($_POST['idFlete']) : NULL;
        $fletes->ruta = isset($_POST['ruta']) ? trim($_POST['ruta']) : NULL;
        $fletes->flete = isset($_POST['flete']) ? trim($_POST['flete']) : NULL;

        // --No se adjunta un archivo nuevo--
        if (Validar::numeros($fletes->id) && Validar::numeros($fletes->ruta) && Validar::float($fletes->flete, '.')) {
            $fletes->parametrizacionFlete();
        } else {
            // --Error de validación--
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
