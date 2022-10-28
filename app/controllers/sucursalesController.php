<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(MODELS . 'modelSucursales.php');

class SucursalesController
{
    public function create(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $sucursal = new Sucursal($db);

        // --Seteo de valores existentes en el POST--
        $sucursal->descripcion = isset($_POST['descripcion']) ? strtoupper(trim($_POST['descripcion'])) : NULL;
        $sucursal->direccion = isset($_POST['direccion']) ? strtoupper(trim($_POST['direccion'])) : NULL;
        $sucursal->telefono = isset($_POST['telefono']) ? strtoupper(trim($_POST['telefono'])) : NULL;
        $sucursal->email = isset($_POST['email']) ? strtoupper(trim($_POST['email'])) : NULL;

        if (
            Validar::alfanumerico($sucursal->descripcion) && Validar::direccion($sucursal->direccion) &&
            Validar::numeros($sucursal->telefono) && Validar::correo($sucursal->email)
        ) {
            $sucursal->createSucursal();
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
        $sucursal = new Sucursal($db);

        $sucursal->draw = htmlspecialchars($_POST['draw']);
        $sucursal->row = htmlspecialchars($_POST['start']);
        $sucursal->rowperpage = htmlspecialchars($_POST['length']);
        $sucursal->columnIndex = htmlspecialchars($_POST['order'][0]['column']);
        $sucursal->columnName = htmlspecialchars($_POST['columns'][$sucursal->columnIndex]['data']);
        $sucursal->columnSortOrder = htmlspecialchars($_POST['order'][0]['dir']);
        $sucursal->searchValue = htmlspecialchars($_POST['search']['value']);

        $sucursal->readAllDaTableSucursal();
    }

    public function status(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $sucursal = new Sucursal($db);

        // --Seteo de valores existentes en el POST--
        $sucursal->id = isset($_POST['idSucursal']) ? strtoupper(trim($_POST['idSucursal'])) : NULL;
        $sucursal->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        if (Validar::numeros($sucursal->id) && Validar::numeros($sucursal->status)) {
            $sucursal->statusSucursal();
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
        $sucursal = new Sucursal($db);

        // --Seteo de valores existentes en el POST--
        $sucursal->id = isset($_POST['idSucursal']) ? strtoupper(trim($_POST['idSucursal'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($sucursal->id)) {
            $sucursal->dataSucursal();
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
        $sucursal = new Sucursal($db);

        // --Seteo de valores existentes en el POST--
        $sucursal->id = isset($_POST['idSucursal']) ? strtoupper(trim($_POST['idSucursal'])) : NULL;
        $sucursal->descripcion = isset($_POST['descripcion']) ? strtoupper(trim($_POST['descripcion'])) : NULL;
        $sucursal->direccion = isset($_POST['direccion']) ? strtoupper(trim($_POST['direccion'])) : NULL;
        $sucursal->telefono = isset($_POST['telefono']) ? strtoupper(trim($_POST['telefono'])) : NULL;
        $sucursal->email = isset($_POST['email']) ? strtoupper(trim($_POST['email'])) : NULL;


        if (
            Validar::alfanumerico($sucursal->descripcion) && Validar::direccion($sucursal->direccion) &&
            Validar::numeros($sucursal->telefono) && Validar::correo($sucursal->email)
        ) {
            $sucursal->updateSucursal();
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
        $sucursal = new Sucursal($db);

        // --Seteo de valores existentes en el POST--
        $sucursal->id = isset($_POST['idSucursal']) ? strtoupper(trim($_POST['idSucursal'])) : NULL;

        if (Validar::numeros($sucursal->id)) {
            $sucursal->deleteSucursal();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
