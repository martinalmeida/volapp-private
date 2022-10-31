<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(MODELS . 'modelModulos.php');

class ModulosController
{

    public function getModulo(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $modulo = new Modulo($db);

        $modulo->modulosPrincipales();
    }

    public function getData(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $modulo = new Modulo($db);

        $modulo->dataModulo();
    }

    public function getAsignados(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $modulo = new Modulo($db);

        // --Seteo de valores existentes en el POST--
        $modulo->idRol = isset($_POST['idRol']) ? strtoupper(trim($_POST['idRol'])) : NULL;
        $modulo->idModulo = isset($_POST['idModulo']) ? strtoupper(trim($_POST['idModulo'])) : NULL;

        if (Validar::numeros($modulo->idRol)) {
            $modulo->modulosAsiganados();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }

    public function getNoAsignados(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $modulo = new Modulo($db);

        // --Seteo de valores existentes en el POST--
        $modulo->idRol = isset($_POST['idRol']) ? strtoupper(trim($_POST['idRol'])) : NULL;
        $modulo->idModulo = isset($_POST['idModulo']) ? strtoupper(trim($_POST['idModulo'])) : NULL;

        if (Validar::numeros($modulo->idRol)) {
            $modulo->modulosNoAsiganados();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }

    public function asignacion(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $modulo = new Modulo($db);

        // --Seteo de valores existentes en el POST--
        $modulo->idRol = isset($_POST['idRol']) ? strtoupper(trim($_POST['idRol'])) : NULL;
        $modulo->idModulo = isset($_POST['idModulo']) ? strtoupper(trim($_POST['idModulo'])) : NULL;

        if (Validar::numeros($modulo->idRol)) {
            $modulo->modulosNoAsiganados();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
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
}
