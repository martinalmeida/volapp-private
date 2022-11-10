<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(LIBRARIES . 'utilidades.php');
include(MODELS . 'modelSocios.php');

class SociosController
{
    public function read(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $socios = new Socio($db);

        $socios->getReadPermisos();
    }

    public function write(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $socios = new Socio($db);

        $socios->getWritePermisos();
    }

    public function create(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $socios = new Socio($db);

        // --Seteo de valores existentes en el POST--
        $socios->kilometraje = isset($_POST['kilometraje']) ? strtoupper(trim($_POST['kilometraje'])) : NULL;
        $socios->tarifa = isset($_POST['tarifa']) ? strtoupper(trim($_POST['tarifa'])) : NULL;
        $socios->idRuta = isset($_POST['ruta']) ? strtoupper(trim($_POST['ruta'])) : NULL;
        $socios->idVehiculo = isset($_POST['vehiculo']) ? strtoupper(trim($_POST['vehiculo'])) : NULL;

        if (
            Validar::numeros($socios->kilometraje) && Validar::numeros($socios->tarifa) && Validar::numeros($socios->tarifa) &&
            Validar::numeros($socios->tarifa)
        ) {
            $socios->createSocio();
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
        $socios = new Socio($db);

        $socios->draw = htmlspecialchars($_POST['draw']);
        $socios->row = htmlspecialchars($_POST['start']);
        $socios->rowperpage = htmlspecialchars($_POST['length']);
        $socios->columnIndex = htmlspecialchars($_POST['order'][0]['column']);
        $socios->columnName = htmlspecialchars($_POST['columns'][$socios->columnIndex]['data']);
        $socios->columnSortOrder = htmlspecialchars($_POST['order'][0]['dir']);
        $socios->searchValue = htmlspecialchars($_POST['search']['value']);

        $socios->readAllDaTableSocios();
    }

    public function status(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $socios = new Socio($db);

        // --Seteo de valores existentes en el POST--
        $socios->id = isset($_POST['idSocio']) ? strtoupper(trim($_POST['idSocio'])) : NULL;
        $socios->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        if (Validar::numeros($socios->id) && Validar::numeros($socios->status)) {
            $socios->statusSocio();
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
        $socios = new Socio($db);

        // --Seteo de valores existentes en el POST--
        $socios->id = isset($_POST['idSocio']) ? strtoupper(trim($_POST['idSocio'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($socios->id)) {
            $socios->dataSocio();
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
        $socios = new Socio($db);

        // --Seteo de valores existentes en el POST--
        $socios->id = isset($_POST['idSocio']) ? strtoupper(trim($_POST['idSocio'])) : NULL;
        $socios->kilometraje = isset($_POST['kilometraje']) ? strtoupper(trim($_POST['kilometraje'])) : NULL;
        $socios->tarifa = isset($_POST['tarifa']) ? strtoupper(trim($_POST['tarifa'])) : NULL;
        $socios->idRuta = isset($_POST['ruta']) ? strtoupper(trim($_POST['ruta'])) : NULL;
        $socios->idVehiculo = isset($_POST['vehiculo']) ? strtoupper(trim($_POST['vehiculo'])) : NULL;


        if (
            Validar::numeros($socios->kilometraje) && Validar::numeros($socios->tarifa) && Validar::numeros($socios->idRuta) &&
            Validar::numeros($socios->idVehiculo) && Validar::numeros($socios->id)
        ) {
            $socios->updateSocio();
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
        $socios = new Socio($db);

        // --Seteo de valores existentes en el POST--
        $socios->id = isset($_POST['idSocio']) ? strtoupper(trim($_POST['idSocio'])) : NULL;

        if (Validar::numeros($socios->id)) {
            $socios->deleteRuta();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
