<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(MODELS . 'modelSelects.php');

class selectsController
{

    public function getSucursal(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $select = new Select($db);

        $select->selectSucursales();
    }

    public function getRol(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $select = new Select($db);

        $select->selectRol();
    }

    public function getPlaca(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $select = new Select($db);

        $select->selectVehiculo();
    }

    public function getRuta(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $select = new Select($db);

        $select->selectRuta();
    }

    public function getMaterial(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $select = new Select($db);

        $select->selectMaterial();
    }

    public function getContrato(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $select = new Select($db);

        $select->selectContrato();
    }

    public function getVehiculo(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $select = new Select($db);

        $select->selectVehiculo();
    }

    public function getTipoMaquinaria(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $select = new Select($db);

        $select->selectTipoMaquinaria();
    }

    public function getAcuerdoAlquiler(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $select = new Select($db);

        // --Seteo de valores existentes en el POST--
        $select->id = isset($_POST['idMaquinaria']) ? strtoupper(trim($_POST['idMaquinaria'])) : NULL;

        if (Validar::numeros($select->id)) {
            $select->selectAcuerdoAlquiler();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }

    public function getAcuerdoFlete(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $select = new Select($db);

        // --Seteo de valores existentes en el POST--
        $select->id = isset($_POST['idMaquinaria']) ? strtoupper(trim($_POST['idMaquinaria'])) : NULL;

        if (Validar::numeros($select->id)) {
            $select->selectAcuerdoFlete();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
