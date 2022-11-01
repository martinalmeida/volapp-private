<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(MODELS . 'modelContratos.php');

class ContratosController
{
    public function read(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $contrato = new Contrato($db);

        $contrato->getReadPermisos();
    }

    public function write(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $contrato = new Contrato($db);

        $contrato->getWritePermisos();
    }

    public function create(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $contrato = new Contrato($db);

        // --Seteo de valores existentes en el POST--
        $contrato->nombre = isset($_POST['nombre']) ? strtoupper(trim($_POST['nombre'])) : NULL;
        $contrato->descripcion = isset($_POST['descripcion']) ? strtoupper(trim($_POST['descripcion'])) : NULL;
        $contrato->representante = isset($_POST['representante']) ? strtoupper(trim($_POST['representante'])) : NULL;
        $contrato->telefono = isset($_POST['telefono']) ? strtoupper(trim($_POST['telefono'])) : NULL;
        $contrato->email = isset($_POST['email']) ? strtoupper(trim($_POST['email'])) : NULL;

        if (
            Validar::alfanumerico($contrato->nombre) && Validar::patronalfanumerico1($contrato->descripcion) && Validar::alfanumerico($contrato->representante) &&
            Validar::numeros($contrato->telefono) && Validar::correo($contrato->email)
        ) {
            $contrato->createContrato();
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
        $contrato = new Contrato($db);

        $contrato->draw = htmlspecialchars($_POST['draw']);
        $contrato->row = htmlspecialchars($_POST['start']);
        $contrato->rowperpage = htmlspecialchars($_POST['length']);
        $contrato->columnIndex = htmlspecialchars($_POST['order'][0]['column']);
        $contrato->columnName = htmlspecialchars($_POST['columns'][$contrato->columnIndex]['data']);
        $contrato->columnSortOrder = htmlspecialchars($_POST['order'][0]['dir']);
        $contrato->searchValue = htmlspecialchars($_POST['search']['value']);

        $contrato->readAllDaTableContrato();
    }

    public function status(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $contrato = new Contrato($db);

        // --Seteo de valores existentes en el POST--
        $contrato->id = isset($_POST['idContrato']) ? strtoupper(trim($_POST['idContrato'])) : NULL;
        $contrato->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        if (Validar::numeros($contrato->id) && Validar::numeros($contrato->status)) {
            $contrato->statusContrato();
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
        $contrato = new Contrato($db);

        // --Seteo de valores existentes en el POST--
        $contrato->id = isset($_POST['idContrato']) ? strtoupper(trim($_POST['idContrato'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($contrato->id)) {
            $contrato->dataContrato();
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
        $contrato = new Contrato($db);

        // --Seteo de valores existentes en el POST--
        $contrato->id = isset($_POST['idContrato']) ? strtoupper(trim($_POST['idContrato'])) : NULL;
        $contrato->nombre = isset($_POST['nombre']) ? strtoupper(trim($_POST['nombre'])) : NULL;
        $contrato->descripcion = isset($_POST['descripcion']) ? strtoupper(trim($_POST['descripcion'])) : NULL;
        $contrato->representante = isset($_POST['representante']) ? strtoupper(trim($_POST['representante'])) : NULL;
        $contrato->telefono = isset($_POST['telefono']) ? strtoupper(trim($_POST['telefono'])) : NULL;
        $contrato->email = isset($_POST['email']) ? strtoupper(trim($_POST['email'])) : NULL;


        if (
            Validar::numeros($contrato->id) && Validar::alfanumerico($contrato->nombre) && Validar::patronalfanumerico1($contrato->descripcion) &&
            Validar::alfanumerico($contrato->representante) && Validar::numeros($contrato->telefono) && Validar::correo($contrato->email)
        ) {
            $contrato->updateMaterial();
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
        $contrato = new Contrato($db);

        // --Seteo de valores existentes en el POST--
        $contrato->id = isset($_POST['idContrato']) ? strtoupper(trim($_POST['idContrato'])) : NULL;

        if (Validar::numeros($contrato->id)) {
            $contrato->deleteContrato();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
