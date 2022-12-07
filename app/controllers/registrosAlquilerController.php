<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(LIBRARIES . 'utilidades.php');
include(MODELS . 'modelRegistrosAlquiler.php');

class RegistrosAlquilerController
{
    public function read(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $registros = new RegistrosAlquiler($db);

        $registros->getReadPermisos();
    }

    public function write(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $registros = new RegistrosAlquiler($db);

        $registros->getWritePermisos();
    }

    public function create(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $registros = new RegistrosAlquiler($db);

        // --Seteo de valores existentes en el POST--
        $registros->codFicha = isset($_POST['codFicha']) ? strtoupper(trim($_POST['codFicha'])) : NULL;
        $registros->horometroInicial = isset($_POST['horometroInicial']) ? strtoupper(trim($_POST['horometroInicial'])) : NULL;
        $registros->horometroFin = isset($_POST['horometroFin']) ? strtoupper(trim($_POST['horometroFin'])) : NULL;
        $registros->placa = isset($_POST['placa']) ? strtoupper(trim($_POST['placa'])) : NULL;
        $registros->acuerdo = isset($_POST['acuerdo']) ? strtoupper(trim($_POST['acuerdo'])) : NULL;
        $registros->fechaInicio = isset($_POST['fechaInicial']) ? strtoupper(trim($_POST['fechaInicial'])) : NULL;
        $registros->fechaFin = isset($_POST['fechaFinal']) ? strtoupper(trim($_POST['fechaFinal'])) : NULL;

        if (
            Validar::numeros($registros->horometroInicial) && Validar::numeros($registros->horometroFin) &&
            Validar::numeros($registros->placa) && Validar::numeros($registros->acuerdo) &&
            Validar::fecha($registros->fechaInicio, '/', 'mda') &&  Validar::fecha($registros->fechaFin, '/', 'mda')
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
        $registros = new RegistrosAlquiler($db);

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
        $registros = new RegistrosAlquiler($db);

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
        $registros = new RegistrosAlquiler($db);

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
        $registros = new RegistrosAlquiler($db);

        // --Seteo de valores existentes en el POST--
        $registros->id = isset($_POST['idRegistro']) ? strtoupper(trim($_POST['idRegistro'])) : NULL;
        $registros->codFicha = isset($_POST['codFicha']) ? strtoupper(trim($_POST['codFicha'])) : NULL;
        $registros->horometroInicial = isset($_POST['horometroInicial']) ? strtoupper(trim($_POST['horometroInicial'])) : NULL;
        $registros->horometroFin = isset($_POST['horometroFin']) ? strtoupper(trim($_POST['horometroFin'])) : NULL;
        $registros->placa = isset($_POST['placa']) ? strtoupper(trim($_POST['placa'])) : NULL;
        $registros->acuerdo = isset($_POST['acuerdo']) ? strtoupper(trim($_POST['acuerdo'])) : NULL;
        $registros->fechaInicio = isset($_POST['fechaInicial']) ? strtoupper(trim($_POST['fechaInicial'])) : NULL;
        $registros->fechaFin = isset($_POST['fechaFinal']) ? strtoupper(trim($_POST['fechaFinal'])) : NULL;

        if (
            Validar::numeros($registros->id) && Validar::numeros($registros->horometroInicial) && Validar::numeros($registros->horometroFin) &&
            Validar::numeros($registros->placa) && Validar::numeros($registros->acuerdo) && Validar::fecha($registros->fechaInicio, '/', 'mda') &&
            Validar::fecha($registros->fechaFin, '/', 'mda')
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
        $registros = new RegistrosAlquiler($db);

        // --Seteo de valores existentes en el POST--
        $registros->id = isset($_POST['idRegistro']) ? strtoupper(trim($_POST['idRegistro'])) : NULL;

        if (Validar::numeros($registros->id)) {
            $registros->deleteRegistro();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }

    public function getDataDeducible(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $registros = new RegistrosAlquiler($db);

        // --Seteo de valores existentes en el POST--
        $registros->id = isset($_POST['idRegistro']) ? strtoupper(trim($_POST['idRegistro'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($registros->id)) {
            $registros->dataDeducible();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }

    public function createDeducible(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $registros = new RegistrosAlquiler($db);

        // --Seteo de valores existentes en el POST--
        $registros->id = isset($_POST['idRegistro']) ? strtoupper(trim($_POST['idRegistro'])) : NULL;
        $registros->admon = isset($_POST['admon']) ? strtoupper(trim($_POST['admon'])) : NULL;
        $registros->retefuente = isset($_POST['retefuente']) ? strtoupper(trim($_POST['retefuente'])) : NULL;
        $registros->reteica = isset($_POST['reteica']) ? strtoupper(trim($_POST['reteica'])) : NULL;
        $registros->anticipo = isset($_POST['anticipo']) ? strtoupper(trim($_POST['anticipo'])) : NULL;
        $registros->otros = isset($_POST['otros']) ? strtoupper(trim($_POST['otros'])) : NULL;
        $registros->observacion = isset($_POST['observacionDeducible']) ? strtoupper(trim($_POST['observacionDeducible'])) : NULL;

        if (Validar::numeros($registros->id)) {
            $registros->createDeducible();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }

    public function updateDeducible(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $registros = new RegistrosAlquiler($db);

        // --Seteo de valores existentes en el POST--
        $registros->id = isset($_POST['idRegistro']) ? strtoupper(trim($_POST['idRegistro'])) : NULL;
        $registros->admon = isset($_POST['admon']) ? strtoupper(trim($_POST['admon'])) : NULL;
        $registros->retefuente = isset($_POST['retefuente']) ? strtoupper(trim($_POST['retefuente'])) : NULL;
        $registros->reteica = isset($_POST['reteica']) ? strtoupper(trim($_POST['reteica'])) : NULL;
        $registros->anticipo = isset($_POST['anticipo']) ? strtoupper(trim($_POST['anticipo'])) : NULL;
        $registros->otros = isset($_POST['otros']) ? strtoupper(trim($_POST['otros'])) : NULL;
        $registros->observacion = isset($_POST['observacionDeducible']) ? strtoupper(trim($_POST['observacionDeducible'])) : NULL;

        if (Validar::numeros($registros->id)) {
            $registros->updateDeducible();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
