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
        $alquiler->placa = isset($_POST['placa']) ? strtoupper(trim($_POST['placa'])) : NULL;
        $alquiler->contrato = isset($_POST['contrato']) ? strtoupper(trim($_POST['contrato'])) : NULL;
        $alquiler->standby = isset($_POST['standby']) ? strtoupper(trim($_POST['standby'])) : NULL;
        $alquiler->horaTarifa = isset($_POST['horaTarifa']) ? strtoupper(trim($_POST['horaTarifa'])) : NULL;

        if (
            Validar::numeros($alquiler->placa) && Validar::numeros($alquiler->contrato) &&
            Validar::float($alquiler->standby, '.') && Validar::float($alquiler->horaTarifa, '.')
        ) {
            $alquiler->createAlquiler();
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

        $alquiler->readAllDaTableAlquiler();
    }

    public function status(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $alquiler = new AlquilerProovedores($db);

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
        $alquiler = new AlquilerProovedores($db);

        // --Seteo de valores existentes en el POST--
        $alquiler->id = isset($_POST['idMaquinaria']) ? strtoupper(trim($_POST['idMaquinaria'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($alquiler->id)) {
            $alquiler->dataAlquiler();
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
        $alquiler->id = isset($_POST['idMaquinaria']) ? strtoupper(trim($_POST['idMaquinaria'])) : NULL;
        $alquiler->placa = isset($_POST['placa']) ? strtoupper(trim($_POST['placa'])) : NULL;
        $alquiler->contrato = isset($_POST['contrato']) ? strtoupper(trim($_POST['contrato'])) : NULL;
        $alquiler->standby = isset($_POST['standby']) ? strtoupper(trim($_POST['standby'])) : NULL;
        $alquiler->horaTarifa = isset($_POST['horaTarifa']) ? strtoupper(trim($_POST['horaTarifa'])) : NULL;


        if (
            Validar::numeros($alquiler->id) && Validar::numeros($alquiler->placa) && Validar::numeros($alquiler->contrato) &&
            Validar::float($alquiler->standby, '.') && Validar::float($alquiler->horaTarifa, '.')
        ) {
            $alquiler->updateAlquilar();
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
        $alquiler->id = isset($_POST['idAlquiler']) ? strtoupper(trim($_POST['idAlquiler'])) : NULL;

        if (Validar::numeros($alquiler->id)) {
            $alquiler->deleteAlquiler();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
