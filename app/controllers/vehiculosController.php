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
        // $placas->Apaterno = isset($_POST['Apaterno']) ? strtoupper(trim($_POST['Apaterno'])) : NULL;
        // $placas->Amaterno = isset($_POST['Amaterno']) ? strtoupper(trim($_POST['Amaterno'])) : NULL;
        $placas->telefono = isset($_POST['telefono']) ? strtoupper(trim($_POST['telefono'])) : NULL;
        $placas->email = isset($_POST['email']) ? strtoupper(trim($_POST['email'])) : NULL;
        $placas->fechaSoat = isset($_POST['fechaSoat']) ? trim($_POST['fechaSoat']) : NULL;
        $placas->fechaLicencia = isset($_POST['fechaLicencia']) ? trim($_POST['fechaLicencia']) : NULL;
        $placas->fecchaTdr = isset($_POST['fecchaTdr']) ? trim($_POST['fecchaTdr']) : NULL;

        if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {
            // --Verificacion de Archivo--
            if ($_FILES['archivo']['error'] != 0) {
                // --Archivo Corrupto--
                echo json_encode(array('status' => '4', 'data' => NULL));
            } else {
                if ($_FILES['archivo']['size'] < 10242880) {
                    $placas->contenType = $_FILES['archivo']['type'];
                    $placas->base64 = base64_encode(file_get_contents($_FILES['archivo']['tmp_name']));
                    if (
                        Validar::patronalfanumerico1($placas->placa) && Validar::alfanumerico($placas->nombresConductor) && Validar::numeros($placas->telefono) &&
                        Validar::correo($placas->email) && Validar::fecha($placas->fechaSoat, '/', 'dma') && Validar::fecha($placas->fechaLicencia, '/', 'dma') &&
                        Validar::fecha($placas->fecchaTdr, '/', 'dma') && Validar::tipoarchivo($placas->contenType, 1)
                    ) {
                        $placas->createPlaca();
                    } else {
                        // --Error de validación--
                        echo json_encode(array('status' => '2', 'data' => NULL));
                    }
                } else {
                    // --Error de validacion de tipo Archivo-- 
                    echo json_encode(array('status' => '6', 'data' => NULL));
                }
            }
        } else {
            // --Falta Archivo--
            echo json_encode(array('status' => '5', 'data' => NULL));
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
        $placas->id = isset($_POST['idVehiculo']) ? strtoupper(trim($_POST['idVehiculo'])) : NULL;
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
        $placas->id = isset($_POST['idVehiculo']) ? trim($_POST['idVehiculo']) : NULL;

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
        $placas->id = isset($_POST['idVehiculo']) ? trim($_POST['idVehiculo']) : NULL;
        $placas->placa = isset($_POST['placa']) ? strtoupper(trim($_POST['placa'])) : NULL;
        $placas->nombresConductor = isset($_POST['nombresConductor']) ? strtoupper(trim($_POST['nombresConductor'])) : NULL;
        // $placas->Apaterno = isset($_POST['Apaterno']) ? strtoupper(trim($_POST['Apaterno'])) : NULL;
        // $placas->Amaterno = isset($_POST['Amaterno']) ? strtoupper(trim($_POST['Amaterno'])) : NULL;
        $placas->telefono = isset($_POST['telefono']) ? strtoupper(trim($_POST['telefono'])) : NULL;
        $placas->email = isset($_POST['email']) ? strtoupper(trim($_POST['email'])) : NULL;
        $placas->fechaSoat = isset($_POST['fechaSoat']) ? trim($_POST['fechaSoat']) : NULL;
        $placas->fechaLicencia = isset($_POST['fechaLicencia']) ? trim($_POST['fechaLicencia']) : NULL;
        $placas->fecchaTdr = isset($_POST['fecchaTdr']) ? trim($_POST['fecchaTdr']) : NULL;
        $empresa->contenType = isset($_POST['contenType']) ? trim($_POST['contenType']) : NULL;
        $empresa->base64 = isset($_POST['base64']) ? trim($_POST['base64']) : NULL;

        if (is_uploaded_file($_FILES['logo']['tmp_name'])) {
            // --Verificacion de Archivo--
            if ($_FILES['archivo']['error'] != 0) {
                // --Archivo Corrupto--
                echo json_encode(array('status' => '4', 'data' => NULL));
            } else {
                if ($_FILES['archivo']['size'] < 10242880) {
                    $placas->contenType = $_FILES['archivo']['type'];
                    $placas->base64 = base64_encode(file_get_contents($_FILES['archivo']['tmp_name']));
                    if (
                        Validar::patronalfanumerico1($placas->placa) && Validar::alfanumerico($placas->nombresConductor) && Validar::numeros($placas->telefono) &&
                        Validar::correo($placas->email) && Validar::fecha($placas->fechaSoat, '/', 'dma') && Validar::fecha($placas->fechaLicencia, '/', 'dma') &&
                        Validar::fecha($placas->fecchaTdr, '/', 'dma') && Validar::tipoarchivo($placas->contenType, 1) && Validar::numeros($placas->id)
                    ) {
                        $placas->createPlaca();
                    } else {
                        // --Error de validación--
                        echo json_encode(array('status' => '2', 'data' => NULL));
                    }
                } else {
                    // --Error de validacion de tipo Archivo-- 
                    echo json_encode(array('status' => '6', 'data' => NULL));
                }
            }
        } else {
            // --No se adjunta un archivo nuevo--
            if (
                Validar::patronalfanumerico1($placas->placa) && Validar::alfanumerico($placas->nombresConductor) && Validar::numeros($placas->telefono) &&
                Validar::correo($placas->email) && Validar::fecha($placas->fechaSoat, '/', 'dma') && Validar::fecha($placas->fechaLicencia, '/', 'dma') &&
                Validar::fecha($placas->fecchaTdr, '/', 'dma') && Validar::numeros($placas->id)
            ) {
                $placas->createPlaca();
            } else {
                // --Error de validación--
                echo json_encode(array('status' => '2', 'data' => NULL));
            }
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
        $placas->id = isset($_POST['idVehiculo']) ? strtoupper(trim($_POST['idVehiculo'])) : NULL;

        if (Validar::numeros($placas->id)) {
            $placas->deletePlaca();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
