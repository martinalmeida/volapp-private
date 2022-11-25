<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(MODELS . 'modelMaquinarias.php');

class MaquinariasController
{
    public function read(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $vehiculo = new Vehiculo($db);

        $vehiculo->getReadPermisos();
    }

    public function write(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $vehiculo = new Vehiculo($db);

        $vehiculo->getWritePermisos();
    }

    public function create(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $vehiculo = new Vehiculo($db);

        // --Seteo de valores existentes en el POST--
        $vehiculo->idMaquinaria = isset($_POST['tpMaquinaria']) ? strtoupper(trim($_POST['tpMaquinaria'])) : NULL;
        $vehiculo->placa = isset($_POST['placa']) ? strtoupper(trim($_POST['placa'])) : NULL;
        $vehiculo->marca = isset($_POST['marca']) ? strtoupper(trim($_POST['marca'])) : NULL;
        $vehiculo->referencia = isset($_POST['referencia']) ? strtoupper(trim($_POST['referencia'])) : NULL;
        $vehiculo->modelo = isset($_POST['modelo']) ? strtoupper(trim($_POST['modelo'])) : NULL;
        $vehiculo->color = isset($_POST['color']) ? strtoupper(trim($_POST['color'])) : NULL;
        $vehiculo->capacidad = isset($_POST['capacidad']) ? strtoupper(trim($_POST['capacidad'])) : NULL;
        $vehiculo->nroSerie = isset($_POST['nroSerie']) ? strtoupper(trim($_POST['nroSerie'])) : NULL;
        $vehiculo->nroSerieChasis = isset($_POST['nroSerieChasis']) ? strtoupper(trim($_POST['nroSerieChasis'])) : NULL;
        $vehiculo->nroMotor = isset($_POST['nroMotor']) ? strtoupper(trim($_POST['nroMotor'])) : NULL;
        $vehiculo->rodaje = isset($_POST['rodaje']) ? strtoupper(trim($_POST['rodaje'])) : NULL;
        $vehiculo->rut = isset($_POST['rut']) ? strtoupper(trim($_POST['rut'])) : NULL;
        $vehiculo->gps = isset($_POST['gps']) ? strtoupper(trim($_POST['gps'])) : NULL;
        $vehiculo->fechaSoat = isset($_POST['fechaSoat']) ? trim($_POST['fechaSoat']) : NULL;
        $vehiculo->fechaTecno = isset($_POST['fechaTecno']) ? trim($_POST['fechaTecno']) : NULL;
        $vehiculo->propietario = isset($_POST['propietario']) ? trim($_POST['propietario']) : NULL;
        $vehiculo->documentoPropietario = isset($_POST['documentoPropietario']) ? trim($_POST['documentoPropietario']) : NULL;
        $vehiculo->telefonoPropietario = isset($_POST['telefonoPropietario']) ? trim($_POST['telefonoPropietario']) : NULL;
        $vehiculo->correoPropietario = isset($_POST['correoPropietario']) ? trim($_POST['correoPropietario']) : NULL;
        $vehiculo->operador = isset($_POST['operador']) ? trim($_POST['operador']) : NULL;
        $vehiculo->documentOperador = isset($_POST['documentOperador']) ? trim($_POST['documentOperador']) : NULL;
        $vehiculo->telefonOperador = isset($_POST['telefonOperador']) ? trim($_POST['telefonOperador']) : NULL;
        $vehiculo->correoOperador = isset($_POST['correoOperador']) ? trim($_POST['correoOperador']) : NULL;

        if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {
            // --Verificacion de Archivo--
            if ($_FILES['archivo']['error'] != 0) {
                // --Archivo Corrupto--
                echo json_encode(array('status' => '4', 'data' => NULL));
            } else {
                if ($_FILES['archivo']['size'] < 10242880) {
                    $vehiculo->contenType = $_FILES['archivo']['type'];
                    $vehiculo->base64 = base64_encode(file_get_contents($_FILES['archivo']['tmp_name']));
                    if (
                        Validar::numeros($vehiculo->idMaquinaria) && Validar::patronalfanumerico1($vehiculo->placa) && Validar::alfanumerico($vehiculo->nombresConductor) &&
                        Validar::correo($vehiculo->email) && Validar::numeros($vehiculo->tpVehiculo) && Validar::fecha($vehiculo->fechaSoat, '/', 'mda') &&
                        Validar::fecha($vehiculo->fechaLicencia, '/', 'mda') && Validar::fecha($vehiculo->fecchaTdr, '/', 'mda') && Validar::tipoarchivo($vehiculo->contenType, 1)
                    ) {
                        $vehiculo->createPlaca();
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
        $vehiculo = new Vehiculo($db);

        $vehiculo->draw = htmlspecialchars($_POST['draw']);
        $vehiculo->row = htmlspecialchars($_POST['start']);
        $vehiculo->rowperpage = htmlspecialchars($_POST['length']);
        $vehiculo->columnIndex = htmlspecialchars($_POST['order'][0]['column']);
        $vehiculo->columnName = htmlspecialchars($_POST['columns'][$vehiculo->columnIndex]['data']);
        $vehiculo->columnSortOrder = htmlspecialchars($_POST['order'][0]['dir']);
        $vehiculo->searchValue = htmlspecialchars($_POST['search']['value']);

        $vehiculo->readAllDaTablePlacas();
    }

    public function status(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $vehiculo = new Vehiculo($db);

        // --Seteo de valores existentes en el POST--
        $vehiculo->id = isset($_POST['idMaquinaria']) ? strtoupper(trim($_POST['idMaquinaria'])) : NULL;
        $vehiculo->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        if (Validar::numeros($vehiculo->id) && Validar::numeros($vehiculo->status)) {
            $vehiculo->statusPLaca();
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
        $vehiculo = new Vehiculo($db);

        // --Seteo de valores existentes en el POST--
        $vehiculo->id = isset($_POST['idMaquinaria']) ? trim($_POST['idMaquinaria']) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($vehiculo->id)) {
            $vehiculo->dataVehiculo();
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
        $vehiculo = new Vehiculo($db);

        // --Seteo de valores existentes en el POST--
        $vehiculo->id = isset($_POST['idMaquinaria']) ? trim($_POST['idMaquinaria']) : NULL;
        $vehiculo->placa = isset($_POST['placa']) ? strtoupper(trim($_POST['placa'])) : NULL;
        $vehiculo->nombresConductor = isset($_POST['nombresConductor']) ? strtoupper(trim($_POST['nombresConductor'])) : NULL;
        // $vehiculo->Apaterno = isset($_POST['Apaterno']) ? strtoupper(trim($_POST['Apaterno'])) : NULL;
        // $vehiculo->Amaterno = isset($_POST['Amaterno']) ? strtoupper(trim($_POST['Amaterno'])) : NULL;
        $vehiculo->telefono = isset($_POST['telefono']) ? strtoupper(trim($_POST['telefono'])) : NULL;
        $vehiculo->email = isset($_POST['email']) ? strtoupper(trim($_POST['email'])) : NULL;
        $vehiculo->tpVehiculo = isset($_POST['tpVehiculo']) ? strtoupper(trim($_POST['tpVehiculo'])) : NULL;
        $vehiculo->fechaSoat = isset($_POST['fechaSoat']) ? trim($_POST['fechaSoat']) : NULL;
        $vehiculo->fechaLicencia = isset($_POST['fechaLicencia']) ? trim($_POST['fechaLicencia']) : NULL;
        $vehiculo->fecchaTdr = isset($_POST['fecchaTdr']) ? trim($_POST['fecchaTdr']) : NULL;
        $vehiculo->contenType = isset($_POST['contenType']) ? trim($_POST['contenType']) : NULL;
        $vehiculo->base64 = isset($_POST['base64']) ? trim($_POST['base64']) : NULL;

        if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {
            // --Verificacion de Archivo--
            if ($_FILES['archivo']['error'] != 0) {
                // --Archivo Corrupto--
                echo json_encode(array('status' => '4', 'data' => NULL));
            } else {
                if ($_FILES['archivo']['size'] < 10242880) {
                    $vehiculo->contenType = $_FILES['archivo']['type'];
                    $vehiculo->base64 = base64_encode(file_get_contents($_FILES['archivo']['tmp_name']));
                    if (
                        Validar::patronalfanumerico1($vehiculo->placa) && Validar::alfanumerico($vehiculo->nombresConductor) && Validar::numeros($vehiculo->telefono) &&
                        Validar::correo($vehiculo->email) && Validar::numeros($vehiculo->tpVehiculo) && Validar::fecha($vehiculo->fechaSoat, '/', 'mda') && Validar::fecha($vehiculo->fechaLicencia, '/', 'mda') &&
                        Validar::fecha($vehiculo->fecchaTdr, '/', 'mda') && Validar::tipoarchivo($vehiculo->contenType, 1) && Validar::numeros($vehiculo->id)
                    ) {
                        $vehiculo->updatePlaca();
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
                Validar::patronalfanumerico1($vehiculo->placa) && Validar::alfanumerico($vehiculo->nombresConductor) && Validar::numeros($vehiculo->telefono) &&
                Validar::correo($vehiculo->email) && Validar::numeros($vehiculo->tpVehiculo) && Validar::fecha($vehiculo->fechaSoat, '/', 'mda') &&
                Validar::fecha($vehiculo->fechaLicencia, '/', 'mda') && Validar::fecha($vehiculo->fecchaTdr, '/', 'mda') && Validar::numeros($vehiculo->id)
            ) {
                $vehiculo->updatePlaca();
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
        $vehiculo = new Vehiculo($db);

        // --Seteo de valores existentes en el POST--
        $vehiculo->id = isset($_POST['idMaquinaria']) ? strtoupper(trim($_POST['idMaquinaria'])) : NULL;

        if (Validar::numeros($vehiculo->id)) {
            $vehiculo->deletePlaca();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
