<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(LIBRARIES . 'utilidades.php');
include(MODELS . 'modelMaquinarias.php');

class MaquinariasController
{
    public function read(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $maquinaria = new Maquinaria($db);

        $maquinaria->getReadPermisos();
    }

    public function write(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $maquinaria = new Maquinaria($db);

        $maquinaria->getWritePermisos();
    }

    public function create(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $maquinaria = new Maquinaria($db);

        // --Seteo de valores existentes en el POST--
        $maquinaria->idTpMaquinaria = isset($_POST['tpMaquinaria']) ? strtoupper(trim($_POST['tpMaquinaria'])) : NULL;
        $maquinaria->placa = isset($_POST['placa']) ? strtoupper(trim($_POST['placa'])) : NULL;
        $maquinaria->marca = isset($_POST['marca']) ? strtoupper(trim($_POST['marca'])) : NULL;
        $maquinaria->referencia = isset($_POST['referencia']) ? strtoupper(trim($_POST['referencia'])) : NULL;
        $maquinaria->modelo = isset($_POST['modelo']) ? strtoupper(trim($_POST['modelo'])) : NULL;
        $maquinaria->color = isset($_POST['color']) ? strtoupper(trim($_POST['color'])) : NULL;
        $maquinaria->capacidad = isset($_POST['capacidad']) ? strtoupper(trim($_POST['capacidad'])) : NULL;
        $maquinaria->nroSerie = isset($_POST['nroSerie']) ? strtoupper(trim($_POST['nroSerie'])) : NULL;
        $maquinaria->nroSerieChasis = isset($_POST['nroSerieChasis']) ? strtoupper(trim($_POST['nroSerieChasis'])) : NULL;
        $maquinaria->nroMotor = isset($_POST['nroMotor']) ? strtoupper(trim($_POST['nroMotor'])) : NULL;
        $maquinaria->rodaje = isset($_POST['rodaje']) ? strtoupper(trim($_POST['rodaje'])) : NULL;
        $maquinaria->rut = isset($_POST['rut']) ? strtoupper(trim($_POST['rut'])) : NULL;
        $maquinaria->gps = isset($_POST['gps']) ? strtoupper(trim($_POST['gps'])) : NULL;
        $maquinaria->fechaSoat = isset($_POST['fechaSoat']) ? trim($_POST['fechaSoat']) : NULL;
        $maquinaria->fechaTecno = isset($_POST['fechaTecno']) ? trim($_POST['fechaTecno']) : NULL;
        $maquinaria->propietario = isset($_POST['propietario']) ? trim($_POST['propietario']) : NULL;
        $maquinaria->documentoPropietario = isset($_POST['documentoPropietario']) ? trim($_POST['documentoPropietario']) : NULL;
        $maquinaria->telefonoPropietario = isset($_POST['telefonoPropietario']) ? trim($_POST['telefonoPropietario']) : NULL;
        $maquinaria->correoPropietario = isset($_POST['correoPropietario']) ? trim($_POST['correoPropietario']) : NULL;
        $maquinaria->operador = isset($_POST['operador']) ? trim($_POST['operador']) : NULL;
        $maquinaria->documentOperador = isset($_POST['documentOperador']) ? trim($_POST['documentOperador']) : NULL;
        $maquinaria->telefonOperador = isset($_POST['telefonOperador']) ? trim($_POST['telefonOperador']) : NULL;
        $maquinaria->correOperador = isset($_POST['correOperador']) ? trim($_POST['correOperador']) : NULL;

        if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {
            // --Verificacion de Archivo--
            if ($_FILES['archivo']['error'] != 0) {
                // --Archivo Corrupto--
                echo json_encode(array('status' => '4', 'data' => NULL));
            } else {
                if ($_FILES['archivo']['size'] < 10242880) {
                    $maquinaria->contenType = $_FILES['archivo']['type'];
                    $maquinaria->base64 = base64_encode(file_get_contents($_FILES['archivo']['tmp_name']));
                    if (
                        Validar::numeros($maquinaria->idTpMaquinaria) && Validar::patronalfanumerico1($maquinaria->placa) && Validar::fecha($maquinaria->fechaSoat, '/', 'mda') &&
                        Validar::fecha($maquinaria->fechaTecno, '/', 'mda') && Validar::patronalfanumerico1($maquinaria->propietario) && Validar::numeros($maquinaria->documentoPropietario) &&
                        Validar::patronalfanumerico1($maquinaria->operador) && Validar::numeros($maquinaria->documentOperador) && Validar::tipoarchivo($maquinaria->contenType, 1)
                    ) {
                        $maquinaria->createMaquinaria();
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
        $maquinaria = new Maquinaria($db);

        $maquinaria->draw = htmlspecialchars($_POST['draw']);
        $maquinaria->row = htmlspecialchars($_POST['start']);
        $maquinaria->rowperpage = htmlspecialchars($_POST['length']);
        $maquinaria->columnIndex = htmlspecialchars($_POST['order'][0]['column']);
        $maquinaria->columnName = htmlspecialchars($_POST['columns'][$maquinaria->columnIndex]['data']);
        $maquinaria->columnSortOrder = htmlspecialchars($_POST['order'][0]['dir']);
        $maquinaria->searchValue = htmlspecialchars($_POST['search']['value']);

        $maquinaria->readAllDaTableMaquinaria();
    }

    public function getFile(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $maquinaria = new Maquinaria($db);

        // --Seteo de valores existentes en el POST--
        $maquinaria->id = isset($_POST['idMaquinaria']) ? strtoupper(trim($_POST['idMaquinaria'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($maquinaria->id)) {
            $maquinaria->traerArchivo();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }

    public function status(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $maquinaria = new Maquinaria($db);

        // --Seteo de valores existentes en el POST--
        $maquinaria->id = isset($_POST['idMaquinaria']) ? strtoupper(trim($_POST['idMaquinaria'])) : NULL;
        $maquinaria->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        if (Validar::numeros($maquinaria->id) && Validar::numeros($maquinaria->status)) {
            $maquinaria->statusMaquinaria();
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
        $maquinaria = new Maquinaria($db);

        // --Seteo de valores existentes en el POST--
        $maquinaria->id = isset($_POST['idMaquinaria']) ? trim($_POST['idMaquinaria']) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($maquinaria->id)) {
            $maquinaria->dataMaquinaria();
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
        $maquinaria = new Maquinaria($db);

        // --Seteo de valores existentes en el POST--
        $maquinaria->id = isset($_POST['idMaquinaria']) ? trim($_POST['idMaquinaria']) : NULL;
        $maquinaria->idTpMaquinaria = isset($_POST['tpMaquinaria']) ? strtoupper(trim($_POST['tpMaquinaria'])) : NULL;
        $maquinaria->placa = isset($_POST['placa']) ? strtoupper(trim($_POST['placa'])) : NULL;
        $maquinaria->marca = isset($_POST['marca']) ? strtoupper(trim($_POST['marca'])) : NULL;
        $maquinaria->referencia = isset($_POST['referencia']) ? strtoupper(trim($_POST['referencia'])) : NULL;
        $maquinaria->modelo = isset($_POST['modelo']) ? strtoupper(trim($_POST['modelo'])) : NULL;
        $maquinaria->color = isset($_POST['color']) ? strtoupper(trim($_POST['color'])) : NULL;
        $maquinaria->capacidad = isset($_POST['capacidad']) ? strtoupper(trim($_POST['capacidad'])) : NULL;
        $maquinaria->nroSerie = isset($_POST['nroSerie']) ? strtoupper(trim($_POST['nroSerie'])) : NULL;
        $maquinaria->nroSerieChasis = isset($_POST['nroSerieChasis']) ? strtoupper(trim($_POST['nroSerieChasis'])) : NULL;
        $maquinaria->nroMotor = isset($_POST['nroMotor']) ? strtoupper(trim($_POST['nroMotor'])) : NULL;
        $maquinaria->rodaje = isset($_POST['rodaje']) ? strtoupper(trim($_POST['rodaje'])) : NULL;
        $maquinaria->rut = isset($_POST['rut']) ? strtoupper(trim($_POST['rut'])) : NULL;
        $maquinaria->gps = isset($_POST['gps']) ? strtoupper(trim($_POST['gps'])) : NULL;
        $maquinaria->fechaSoat = isset($_POST['fechaSoat']) ? trim($_POST['fechaSoat']) : NULL;
        $maquinaria->fechaTecno = isset($_POST['fechaTecno']) ? trim($_POST['fechaTecno']) : NULL;
        $maquinaria->propietario = isset($_POST['propietario']) ? trim($_POST['propietario']) : NULL;
        $maquinaria->documentoPropietario = isset($_POST['documentoPropietario']) ? trim($_POST['documentoPropietario']) : NULL;
        $maquinaria->telefonoPropietario = isset($_POST['telefonoPropietario']) ? trim($_POST['telefonoPropietario']) : NULL;
        $maquinaria->correoPropietario = isset($_POST['correoPropietario']) ? trim($_POST['correoPropietario']) : NULL;
        $maquinaria->operador = isset($_POST['operador']) ? trim($_POST['operador']) : NULL;
        $maquinaria->documentOperador = isset($_POST['documentOperador']) ? trim($_POST['documentOperador']) : NULL;
        $maquinaria->telefonOperador = isset($_POST['telefonOperador']) ? trim($_POST['telefonOperador']) : NULL;
        $maquinaria->correOperador = isset($_POST['correOperador']) ? trim($_POST['correOperador']) : NULL;
        $maquinaria->contenType = isset($_POST['contenType']) ? trim($_POST['contenType']) : NULL;
        $maquinaria->base64 = isset($_POST['base64']) ? trim($_POST['base64']) : NULL;

        if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {
            // --Verificacion de Archivo--
            if ($_FILES['archivo']['error'] != 0) {
                // --Archivo Corrupto--
                echo json_encode(array('status' => '4', 'data' => NULL));
            } else {
                if ($_FILES['archivo']['size'] < 10242880) {
                    $maquinaria->contenType = $_FILES['archivo']['type'];
                    $maquinaria->base64 = base64_encode(file_get_contents($_FILES['archivo']['tmp_name']));
                    if (
                        Validar::numeros($maquinaria->idTpMaquinaria) && Validar::patronalfanumerico1($maquinaria->placa) && Validar::fecha($maquinaria->fechaSoat, '/', 'mda') &&
                        Validar::fecha($maquinaria->fechaTecno, '/', 'mda') && Validar::patronalfanumerico1($maquinaria->propietario) && Validar::numeros($maquinaria->documentoPropietario) &&
                        Validar::patronalfanumerico1($maquinaria->operador) && Validar::numeros($maquinaria->documentOperador) && Validar::tipoarchivo($maquinaria->contenType, 1) && Validar::numeros($maquinaria->id)
                    ) {
                        $maquinaria->updateMaquinaria();
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
                Validar::numeros($maquinaria->idTpMaquinaria) && Validar::patronalfanumerico1($maquinaria->placa) && Validar::fecha($maquinaria->fechaSoat, '/', 'mda') &&
                Validar::fecha($maquinaria->fechaTecno, '/', 'mda') && Validar::patronalfanumerico1($maquinaria->propietario) && Validar::numeros($maquinaria->documentoPropietario) &&
                Validar::patronalfanumerico1($maquinaria->operador) && Validar::numeros($maquinaria->documentOperador) && Validar::tipoarchivo($maquinaria->contenType, 1) && Validar::numeros($maquinaria->id)
            ) {
                $maquinaria->updateMaquinaria();
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
        $maquinaria = new Maquinaria($db);

        // --Seteo de valores existentes en el POST--
        $maquinaria->id = isset($_POST['idMaquinaria']) ? strtoupper(trim($_POST['idMaquinaria'])) : NULL;

        if (Validar::numeros($maquinaria->id)) {
            $maquinaria->deleteMaquinaria();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
