<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(LIBRARIES . 'utilidades.php');
include(MODELS . 'modelAlquilerProovedores.php');

class AlquilerProovedoresController
{
    public function read(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $alquiler = new AlquilerProovedores($db);

        $alquiler->getReadPermisos();
    }

    public function write(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $alquiler = new AlquilerProovedores($db);

        $alquiler->getWritePermisos();
    }

    public function create(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $alquiler = new AlquilerProovedores($db);

        // --Seteo de valores existentes en el POST--
        $alquiler->nombre = isset($_POST['nombre']) ? strtoupper(trim($_POST['nombre'])) : NULL;
        $alquiler->origen = isset($_POST['origen']) ? strtoupper(trim($_POST['origen'])) : NULL;
        $alquiler->destino = isset($_POST['destino']) ? strtoupper(trim($_POST['destino'])) : NULL;
        $alquiler->contrato = isset($_POST['contrato']) ? strtoupper(trim($_POST['contrato'])) : NULL;
        $alquiler->kilometraje = isset($_POST['kilometraje']) ? strtoupper(trim($_POST['kilometraje'])) : NULL;
        $alquiler->tarifa = isset($_POST['tarifa']) ? strtoupper(trim($_POST['tarifa'])) : NULL;

        if (
            Validar::patronalfanumerico1($alquiler->nombre) && Validar::patronalfanumerico1($alquiler->origen) && Validar::patronalfanumerico1($alquiler->destino) &&
            Validar::numeros($alquiler->contrato) && Validar::float($alquiler->kilometraje, '.') && Validar::float($alquiler->tarifa, '.')
        ) {
            $alquiler->createRuta();
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
        $alquiler = new AlquilerProovedores($db);

        $alquiler->draw = htmlspecialchars($_POST['draw']);
        $alquiler->row = htmlspecialchars($_POST['start']);
        $alquiler->rowperpage = htmlspecialchars($_POST['length']);
        $alquiler->columnIndex = htmlspecialchars($_POST['order'][0]['column']);
        $alquiler->columnName = htmlspecialchars($_POST['columns'][$alquiler->columnIndex]['data']);
        $alquiler->columnSortOrder = htmlspecialchars($_POST['order'][0]['dir']);
        $alquiler->searchValue = htmlspecialchars($_POST['search']['value']);

        $alquiler->readAllDaTableRutas();
    }

    public function status(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $alquiler = new AlquilerProovedores($db);

        // --Seteo de valores existentes en el POST--
        $alquiler->id = isset($_POST['idRuta']) ? strtoupper(trim($_POST['idRuta'])) : NULL;
        $alquiler->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        if (Validar::numeros($alquiler->id) && Validar::numeros($alquiler->status)) {
            $alquiler->statusRuta();
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
        $alquiler = new AlquilerProovedores($db);

        // --Seteo de valores existentes en el POST--
        $alquiler->id = isset($_POST['idRuta']) ? strtoupper(trim($_POST['idRuta'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($alquiler->id)) {
            $alquiler->dataRuta();
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
        $alquiler = new AlquilerProovedores($db);

        // --Seteo de valores existentes en el POST--
        $alquiler->id = isset($_POST['idRuta']) ? strtoupper(trim($_POST['idRuta'])) : NULL;
        $alquiler->idRuC = isset($_POST['idRuC']) ? strtoupper(trim($_POST['idRuC'])) : NULL;
        $alquiler->nombre = isset($_POST['nombre']) ? strtoupper(trim($_POST['nombre'])) : NULL;
        $alquiler->origen = isset($_POST['origen']) ? strtoupper(trim($_POST['origen'])) : NULL;
        $alquiler->destino = isset($_POST['destino']) ? strtoupper(trim($_POST['destino'])) : NULL;
        $alquiler->contrato = isset($_POST['contrato']) ? strtoupper(trim($_POST['contrato'])) : NULL;
        $alquiler->kilometraje = isset($_POST['kilometraje']) ? strtoupper(trim($_POST['kilometraje'])) : NULL;
        $alquiler->tarifa = isset($_POST['tarifa']) ? strtoupper(trim($_POST['tarifa'])) : NULL;


        if (
            Validar::patronalfanumerico1($alquiler->nombre) && Validar::patronalfanumerico1($alquiler->origen) && Validar::patronalfanumerico1($alquiler->destino) &&
            Validar::numeros($alquiler->contrato) && Validar::float($alquiler->kilometraje, '.') && Validar::float($alquiler->tarifa, '.') && Validar::numeros($alquiler->id) &&
            Validar::numeros($alquiler->idRuC)
        ) {
            $alquiler->updateRuta();
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
        $alquiler = new AlquilerProovedores($db);

        // --Seteo de valores existentes en el POST--
        $alquiler->id = isset($_POST['idRuta']) ? strtoupper(trim($_POST['idRuta'])) : NULL;

        if (Validar::numeros($alquiler->id)) {
            $alquiler->deleteRuta();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
