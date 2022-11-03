<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(MODELS . 'modelVehiculos.php');

class VehiculosController
{
    public function read(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $placas = new Placa($db);

        $placas->getReadPermisos();
    }

    public function write(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $placas = new Placa($db);

        $placas->getWritePermisos();
    }

    public function create(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $placas = new Placa($db);

        // --Seteo de valores existentes en el POST--
        $placas->placa = isset($_POST['placa']) ? strtoupper(trim($_POST['placa'])) : NULL;
        $placas->nombresConductor = isset($_POST['nombresConductor']) ? strtoupper(trim($_POST['nombresConductor'])) : NULL;
        $placas->Apaterno = isset($_POST['Apaterno']) ? strtoupper(trim($_POST['Apaterno'])) : NULL;
        $placas->Amaterno = isset($_POST['Amaterno']) ? strtoupper(trim($_POST['Amaterno'])) : NULL;
        $placas->telefono = isset($_POST['telefono']) ? strtoupper(trim($_POST['telefono'])) : NULL;
        $placas->email = isset($_POST['email']) ? strtoupper(trim($_POST['email'])) : NULL;

        if (
            Validar::patronalfanumerico1($placas->placa) && Validar::alfanumerico($placas->nombresConductor) && Validar::alfanumerico($placas->Apaterno) &&
            Validar::alfanumerico($placas->Amaterno) && Validar::numeros($placas->telefono) && Validar::correo($placas->email)
        ) {
            $placas->createPlaca();
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
        $placas = new Placa($db);

        $placas->draw = htmlspecialchars($_POST['draw']);
        $placas->row = htmlspecialchars($_POST['start']);
        $placas->rowperpage = htmlspecialchars($_POST['length']);
        $placas->columnIndex = htmlspecialchars($_POST['order'][0]['column']);
        $placas->columnName = htmlspecialchars($_POST['columns'][$placas->columnIndex]['data']);
        $placas->columnSortOrder = htmlspecialchars($_POST['order'][0]['dir']);
        $placas->searchValue = htmlspecialchars($_POST['search']['value']);

        $placas->readAllDaTablePlacas();
    }

    public function status(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $placas = new Placa($db);

        // --Seteo de valores existentes en el POST--
        $placas->id = isset($_POST['idPlaca']) ? strtoupper(trim($_POST['idPlaca'])) : NULL;
        $placas->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        if (Validar::numeros($placas->id) && Validar::numeros($placas->status)) {
            $placas->statusPLaca();
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
        $placas = new Placa($db);

        // --Seteo de valores existentes en el POST--
        $placas->id = isset($_POST['idPlaca']) ? strtoupper(trim($_POST['idPlaca'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($placas->id)) {
            $placas->dataPlaca();
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
        $placas = new Placa($db);

        // --Seteo de valores existentes en el POST--
        $placas->id = isset($_POST['idPlaca']) ? strtoupper(trim($_POST['idPlaca'])) : NULL;
        $placas->placa = isset($_POST['placa']) ? strtoupper(trim($_POST['placa'])) : NULL;
        $placas->nombresConductor = isset($_POST['nombresConductor']) ? strtoupper(trim($_POST['nombresConductor'])) : NULL;
        $placas->Apaterno = isset($_POST['Apaterno']) ? strtoupper(trim($_POST['Apaterno'])) : NULL;
        $placas->Amaterno = isset($_POST['Amaterno']) ? strtoupper(trim($_POST['Amaterno'])) : NULL;
        $placas->telefono = isset($_POST['telefono']) ? strtoupper(trim($_POST['telefono'])) : NULL;
        $placas->email = isset($_POST['email']) ? strtoupper(trim($_POST['email'])) : NULL;


        if (
            Validar::patronalfanumerico1($placas->placa) && Validar::alfanumerico($placas->nombresConductor) && Validar::alfanumerico($placas->Apaterno) &&
            Validar::alfanumerico($placas->Amaterno) && Validar::numeros($placas->telefono) && Validar::correo($placas->email) && Validar::numeros($placas->id)
        ) {
            $placas->updatePlaca();
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
        $placas = new Placa($db);

        // --Seteo de valores existentes en el POST--
        $placas->id = isset($_POST['idPlaca']) ? strtoupper(trim($_POST['idPlaca'])) : NULL;

        if (Validar::numeros($placas->id)) {
            $placas->deletePlaca();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
