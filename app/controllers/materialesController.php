<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(MODELS . 'modelMateriales.php');

class MaterialesController
{
    public function create(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $material = new Material($db);

        // --Seteo de valores existentes en el POST--
        $material->nombre = isset($_POST['nombre']) ? strtoupper(trim($_POST['nombre'])) : NULL;
        $material->descripcion = isset($_POST['descripcion']) ? strtoupper(trim($_POST['descripcion'])) : NULL;

        if (Validar::alfanumerico($material->nombre) && Validar::alfanumerico($material->descripcion)) {
            $material->createMaterial();
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
        $material = new Material($db);

        $material->draw = htmlspecialchars($_POST['draw']);
        $material->row = htmlspecialchars($_POST['start']);
        $material->rowperpage = htmlspecialchars($_POST['length']);
        $material->columnIndex = htmlspecialchars($_POST['order'][0]['column']);
        $material->columnName = htmlspecialchars($_POST['columns'][$material->columnIndex]['data']);
        $material->columnSortOrder = htmlspecialchars($_POST['order'][0]['dir']);
        $material->searchValue = htmlspecialchars($_POST['search']['value']);

        $material->readAllDaTableMateriales();
    }

    public function status(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $material = new Material($db);

        // --Seteo de valores existentes en el POST--
        $material->id = isset($_POST['idMaterial']) ? strtoupper(trim($_POST['idMaterial'])) : NULL;
        $material->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        if (Validar::numeros($material->id) && Validar::numeros($material->status)) {
            $material->statusMaterial();
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
        $material = new Material($db);

        // --Seteo de valores existentes en el POST--
        $material->id = isset($_POST['idMaterial']) ? strtoupper(trim($_POST['idMaterial'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($material->id)) {
            $material->dataMaterial();
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
        $material = new Material($db);

        // --Seteo de valores existentes en el POST--
        $material->id = isset($_POST['idMaterial']) ? strtoupper(trim($_POST['idMaterial'])) : NULL;
        $material->nombre = isset($_POST['nombre']) ? strtoupper(trim($_POST['nombre'])) : NULL;
        $material->descripcion = isset($_POST['descripcion']) ? strtoupper(trim($_POST['descripcion'])) : NULL;


        if (Validar::alfanumerico($material->nombre) && Validar::alfanumerico($material->descripcion)) {
            $material->updateMaterial();
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
        $material = new Material($db);

        // --Seteo de valores existentes en el POST--
        $material->id = isset($_POST['idMaterial']) ? strtoupper(trim($_POST['idMaterial'])) : NULL;

        if (Validar::numeros($material->id)) {
            $material->deletePlaca();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
