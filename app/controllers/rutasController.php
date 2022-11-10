<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(LIBRARIES . 'utilidades.php');
include(MODELS . 'modelRutas.php');

class RutasController
{
    public function read(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $rutas = new Ruta($db);

        $rutas->getReadPermisos();
    }

    public function write(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $rutas = new Ruta($db);

        $rutas->getWritePermisos();
    }

    public function create(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $rutas = new Ruta($db);

        // --Seteo de valores existentes en el POST--
        $rutas->nombre = isset($_POST['nombre']) ? strtoupper(trim($_POST['nombre'])) : NULL;
        $rutas->origen = isset($_POST['origen']) ? strtoupper(trim($_POST['origen'])) : NULL;
        $rutas->destino = isset($_POST['destino']) ? strtoupper(trim($_POST['destino'])) : NULL;
        $rutas->contrato = isset($_POST['contrato']) ? strtoupper(trim($_POST['contrato'])) : NULL;
        $rutas->kilometraje = isset($_POST['kilometraje']) ? strtoupper(trim($_POST['kilometraje'])) : NULL;
        $rutas->tarifa = isset($_POST['tarifa']) ? strtoupper(trim($_POST['tarifa'])) : NULL;

        if (
            Validar::patronalfanumerico1($rutas->nombre) && Validar::patronalfanumerico1($rutas->origen) && Validar::patronalfanumerico1($rutas->destino) &&
            Validar::numeros($rutas->contrato) && Validar::float($rutas->kilometraje, '.') && Validar::float($rutas->tarifa, '.')
        ) {
            $rutas->createRuta();
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
        $rutas = new Ruta($db);

        $rutas->draw = htmlspecialchars($_POST['draw']);
        $rutas->row = htmlspecialchars($_POST['start']);
        $rutas->rowperpage = htmlspecialchars($_POST['length']);
        $rutas->columnIndex = htmlspecialchars($_POST['order'][0]['column']);
        $rutas->columnName = htmlspecialchars($_POST['columns'][$rutas->columnIndex]['data']);
        $rutas->columnSortOrder = htmlspecialchars($_POST['order'][0]['dir']);
        $rutas->searchValue = htmlspecialchars($_POST['search']['value']);

        $rutas->readAllDaTableRutas();
    }

    public function status(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $rutas = new Ruta($db);

        // --Seteo de valores existentes en el POST--
        $rutas->id = isset($_POST['idRuta']) ? strtoupper(trim($_POST['idRuta'])) : NULL;
        $rutas->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        if (Validar::numeros($rutas->id) && Validar::numeros($rutas->status)) {
            $rutas->statusRuta();
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
        $rutas = new Ruta($db);

        // --Seteo de valores existentes en el POST--
        $rutas->id = isset($_POST['idRuta']) ? strtoupper(trim($_POST['idRuta'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($rutas->id)) {
            $rutas->dataRuta();
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
        $rutas = new Ruta($db);

        // --Seteo de valores existentes en el POST--
        $rutas->id = isset($_POST['idRuta']) ? strtoupper(trim($_POST['idRuta'])) : NULL;
        $rutas->idRuC = isset($_POST['idRuC']) ? strtoupper(trim($_POST['idRuC'])) : NULL;
        $rutas->nombre = isset($_POST['nombre']) ? strtoupper(trim($_POST['nombre'])) : NULL;
        $rutas->origen = isset($_POST['origen']) ? strtoupper(trim($_POST['origen'])) : NULL;
        $rutas->destino = isset($_POST['destino']) ? strtoupper(trim($_POST['destino'])) : NULL;
        $rutas->contrato = isset($_POST['contrato']) ? strtoupper(trim($_POST['contrato'])) : NULL;
        $rutas->kilometraje = isset($_POST['kilometraje']) ? strtoupper(trim($_POST['kilometraje'])) : NULL;
        $rutas->tarifa = isset($_POST['tarifa']) ? strtoupper(trim($_POST['tarifa'])) : NULL;


        if (
            Validar::patronalfanumerico1($rutas->nombre) && Validar::patronalfanumerico1($rutas->origen) && Validar::patronalfanumerico1($rutas->destino) &&
            Validar::numeros($rutas->contrato) && Validar::float($rutas->kilometraje, '.') && Validar::float($rutas->tarifa, '.') && Validar::numeros($rutas->id) &&
            Validar::numeros($rutas->idRuC)
        ) {
            $rutas->updateRuta();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }

    public function delete(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $rutas = new Ruta($db);

        // --Seteo de valores existentes en el POST--
        $rutas->id = isset($_POST['idRuta']) ? strtoupper(trim($_POST['idRuta'])) : NULL;

        if (Validar::numeros($rutas->id)) {
            $rutas->deleteRuta();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
