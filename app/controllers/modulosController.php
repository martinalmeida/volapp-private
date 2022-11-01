<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(MODELS . 'modelModulos.php');

class ModulosController
{



    public function getData(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $modulo = new Modulo($db);

        $modulo->dataModulo();
    }

    public function getPermissions(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $modulo = new Modulo($db);

        // --Seteo de valores existentes en el POST--
        $modulo->idRol = isset($_POST['idRol']) ? strtoupper(trim($_POST['idRol'])) : NULL;
        $modulo->id = isset($_POST['idModulo']) ? strtoupper(trim($_POST['idModulo'])) : NULL;


        if (Validar::numeros($modulo->idRol) && Validar::numeros($modulo->id)) {
            $modulo->dataPermissions();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }

    public function permisosRead(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $modulo = new Modulo($db);

        // --Seteo de valores existentes en el POST--
        $modulo->idPermiso = isset($_POST['idPermisos']) ? strtoupper(trim($_POST['idPermisos'])) : NULL;
        $modulo->read = isset($_POST['permiso']) ? strtoupper(trim($_POST['permiso'])) : NULL;

        if (Validar::numeros($modulo->idPermiso) && Validar::numeros($modulo->read)) {
            $modulo->readPermisos();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }

    public function permisosWrite(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $modulo = new Modulo($db);

        // --Seteo de valores existentes en el POST--
        $modulo->idPermiso = isset($_POST['idPermisos']) ? strtoupper(trim($_POST['idPermisos'])) : NULL;
        $modulo->write = isset($_POST['permiso']) ? strtoupper(trim($_POST['permiso'])) : NULL;

        if (Validar::numeros($modulo->idPermiso) && Validar::numeros($modulo->write)) {
            $modulo->writePermisos();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }

    public function permisosUpdate(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $modulo = new Modulo($db);

        // --Seteo de valores existentes en el POST--
        $modulo->idPermiso = isset($_POST['idPermisos']) ? strtoupper(trim($_POST['idPermisos'])) : NULL;
        $modulo->update = isset($_POST['permiso']) ? strtoupper(trim($_POST['permiso'])) : NULL;

        if (Validar::numeros($modulo->idPermiso) && Validar::numeros($modulo->update)) {
            $modulo->updatePermisos();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }

    public function permisosDelete(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $modulo = new Modulo($db);

        // --Seteo de valores existentes en el POST--
        $modulo->idPermiso = isset($_POST['idPermisos']) ? strtoupper(trim($_POST['idPermisos'])) : NULL;
        $modulo->delete = isset($_POST['permiso']) ? strtoupper(trim($_POST['permiso'])) : NULL;

        if (Validar::numeros($modulo->idPermiso) && Validar::numeros($modulo->delete)) {
            $modulo->deletePermisos();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
