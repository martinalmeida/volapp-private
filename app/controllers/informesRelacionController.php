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

        $informes->draw = htmlspecialchars($_POST['draw']);
        $informes->row = htmlspecialchars($_POST['start']);
        $informes->rowperpage = htmlspecialchars($_POST['length']);
        $informes->columnIndex = htmlspecialchars($_POST['order'][0]['column']);
        $informes->columnName = htmlspecialchars($_POST['columns'][$informes->columnIndex]['data']);
        $informes->columnSortOrder = htmlspecialchars($_POST['order'][0]['dir']);

        $informes->placa = isset($_POST['placa']) ? strtoupper(trim($_POST['placa'])) : NULL;
        $informes->contrato = isset($_POST['contrato']) ? strtoupper(trim($_POST['contrato'])) : NULL;
        $informes->fechaInicio = isset($_POST['fechaInicio']) ? strtoupper(trim($_POST['fechaInicio'])) : NULL;
        $informes->fechaFin = isset($_POST['fechaFin']) ? strtoupper(trim($_POST['fechaFin'])) : NULL;
        echo $_POST['form'][0]['value'] . '\n';
        echo $_POST['form'][1]['value'];
        echo $_POST['form'][2]['value'];
        echo $_POST['form'][3]['value'];
        foreach ($data as $key => $val) {
            $val->Descripcion; // Aceite, Caja
            $val->Codigo;      // 2222222, 1111111
            $val->Precio;      // 45, 50
            $val->Eliminar;    // Eliminar, Eliminar
        }
        exit;
        $informes->tableRelacionAlquiler();
    }
}
