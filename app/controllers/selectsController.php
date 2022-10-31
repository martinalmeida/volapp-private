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
}
