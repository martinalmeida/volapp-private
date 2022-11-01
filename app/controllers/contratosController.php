<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(MODELS . 'modelContratos.php');

class ContratosController
{
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

        if (Validar::alfanumerico($contrato->nombre) && Validar::alfanumerico($contrato->descripcion)) {
            $contrato->createMaterial();
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

        $contrato->readAllDaTableMateriales();
    }

    public function status(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $contrato = new Contrato($db);

        // --Seteo de valores existentes en el POST--
        $contrato->id = isset($_POST['idMaterial']) ? strtoupper(trim($_POST['idMaterial'])) : NULL;
        $contrato->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        if (Validar::numeros($contrato->id) && Validar::numeros($contrato->status)) {
            $contrato->statusMaterial();
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
        $contrato->id = isset($_POST['idMaterial']) ? strtoupper(trim($_POST['idMaterial'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($contrato->id)) {
            $contrato->dataMaterial();
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
        $contrato->id = isset($_POST['idMaterial']) ? strtoupper(trim($_POST['idMaterial'])) : NULL;
        $contrato->nombre = isset($_POST['nombre']) ? strtoupper(trim($_POST['nombre'])) : NULL;
        $contrato->descripcion = isset($_POST['descripcion']) ? strtoupper(trim($_POST['descripcion'])) : NULL;


        if (Validar::alfanumerico($contrato->nombre) && Validar::alfanumerico($contrato->descripcion)) {
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
        $contrato->id = isset($_POST['idMaterial']) ? strtoupper(trim($_POST['idMaterial'])) : NULL;

        if (Validar::numeros($contrato->id)) {
            $contrato->deletePlaca();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
