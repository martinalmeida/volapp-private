<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(MODELS . 'modelInformesRelacion.php');


class InformesRelacionController
{
    public function read(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $informes = new InformesRelacion($db);

        $informes->getReadPermisos();
    }

    public function write(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $informes = new InformesRelacion($db);

        $informes->getWritePermisos();
    }

    public function getRuta(): void
    {
        include_once(ROOTS);
        // --Seteo de valores existentes en el POST--
        $numero = isset($_POST['idRuta']) ? strtoupper(trim($_POST['idRuta'])) : NULL;

        if (Validar::numeros($numero)) {
            echo json_encode(array('status' => '1', 'data' => NULL, 'url' => Roots::informesRoots($numero)));
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL, 'url' => NULL));
        }
    }

    public function relacionAlquiler(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $informes = new InformesRelacion($db);

        $informes->placa = isset($_POST['placa']) ? strtoupper(trim($_POST['placa'])) : NULL;
        $informes->contrato = isset($_POST['contrato']) ? strtoupper(trim($_POST['contrato'])) : NULL;
        $informes->fechaInicio = isset($_POST['fechaInicio']) ? strtoupper(trim($_POST['fechaInicio'])) : NULL;
        $informes->fechaFin = isset($_POST['fechaFin']) ? strtoupper(trim($_POST['fechaFin'])) : NULL;

        $informes->tableRelacionAlquiler();
    }
}
