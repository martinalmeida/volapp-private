<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(LIBRARIES . 'utilidades.php');
include(MODELS . 'modelRegistros.php');

class RegistrosController
{
    public function read(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $registros = new Registro($db);

        $registros->getReadPermisos();
    }

    public function write(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $registros = new Registro($db);

        $registros->getWritePermisos();
    }

    public function create(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $registros = new Registro($db);

        // --Seteo de valores existentes en el POST--
        $registros->placa = isset($_POST['placa']) ? strtoupper(trim($_POST['placa'])) : NULL;
        $registros->ruta = isset($_POST['ruta']) ? strtoupper(trim($_POST['ruta'])) : NULL;
        $registros->material = isset($_POST['material']) ? strtoupper(trim($_POST['material'])) : NULL;
        $registros->nota = isset($_POST['nota']) ? strtoupper(trim($_POST['nota'])) : NULL;

        if (
            Validar::numeros($registros->placa) && Validar::numeros($registros->ruta)
            && Validar::numeros($registros->material) && Validar::patronalfanumerico1($registros->nota)
        ) {
            $registros->createRegistro();
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
        $registros = new Registro($db);

        $registros->draw = htmlspecialchars($_POST['draw']);
        $registros->row = htmlspecialchars($_POST['start']);
        $registros->rowperpage = htmlspecialchars($_POST['length']);
        $registros->columnIndex = htmlspecialchars($_POST['order'][0]['column']);
        $registros->columnName = htmlspecialchars($_POST['columns'][$registros->columnIndex]['data']);
        $registros->columnSortOrder = htmlspecialchars($_POST['order'][0]['dir']);
        $registros->searchValue = htmlspecialchars($_POST['search']['value']);

        $registros->readAllDaTableRegistro();
    }

    public function status(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $registros = new Registro($db);

        // --Seteo de valores existentes en el POST--
        $registros->id = isset($_POST['idRegistro']) ? strtoupper(trim($_POST['idRegistro'])) : NULL;
        $registros->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        if (Validar::numeros($registros->id) && Validar::numeros($registros->status)) {
            $registros->statusRegistro();
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
        $registros = new Registro($db);

        // --Seteo de valores existentes en el POST--
        $registros->id = isset($_POST['idRegistro']) ? strtoupper(trim($_POST['idRegistro'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($registros->id)) {
            $registros->dataRegistro();
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
        $registros = new Registro($db);

        // --Seteo de valores existentes en el POST--
        $registros->id = isset($_POST['idRegistro']) ? strtoupper(trim($_POST['idRegistro'])) : NULL;
        $registros->placa = isset($_POST['placa']) ? strtoupper(trim($_POST['placa'])) : NULL;
        $registros->ruta = isset($_POST['ruta']) ? strtoupper(trim($_POST['ruta'])) : NULL;
        $registros->material = isset($_POST['material']) ? strtoupper(trim($_POST['material'])) : NULL;
        $registros->nota = isset($_POST['nota']) ? strtoupper(trim($_POST['nota'])) : NULL;


        if (
            Validar::numeros($registros->id) && Validar::numeros($registros->placa) && Validar::numeros($registros->ruta)
            && Validar::numeros($registros->material) && Validar::patronalfanumerico1($registros->nota)
        ) {
            $registros->updateRegistro();
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
        $registros = new Registro($db);

        // --Seteo de valores existentes en el POST--
        $registros->id = isset($_POST['idRegistro']) ? strtoupper(trim($_POST['idRegistro'])) : NULL;

        if (Validar::numeros($registros->id)) {
            $registros->deleteRegistro();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
