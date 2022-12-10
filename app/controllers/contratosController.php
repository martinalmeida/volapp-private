<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(MODELS . 'modelContratos.php');

class ContratosController
{
    public function read(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $contrato = new Contrato($db);

        $contrato->getReadPermisos();
    }

    public function write(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $contrato = new Contrato($db);

        $contrato->getWritePermisos();
    }

    public function create(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $contrato = new Contrato($db);

        // --Seteo de valores existentes en el POST--
        $contrato->fechaInicio = isset($_POST['fechaInicio']) ? trim($_POST['fechaInicio']) : NULL;
        $contrato->fechaFin = isset($_POST['fechaFin']) ? trim($_POST['fechaFin']) : NULL;
        $contrato->titulo = isset($_POST['titulo']) ? strtoupper(trim($_POST['titulo'])) : NULL;
        $contrato->representante = isset($_POST['representante']) ? strtoupper(trim($_POST['representante'])) : NULL;
        $contrato->telefono = isset($_POST['telefono']) ? strtoupper(trim($_POST['telefono'])) : NULL;
        $contrato->email = isset($_POST['email']) ? strtoupper(trim($_POST['email'])) : NULL;

        if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {
            // --Verificacion de Archivo--
            if ($_FILES['archivo']['error'] != 0) {
                // --Archivo Corrupto--
                echo json_encode(array('status' => '4', 'data' => NULL));
            } else {
                if ($_FILES['archivo']['size'] <= 4000000) {
                    $contrato->contenType = $_FILES['archivo']['type'];
                    $contrato->base64 = base64_encode(file_get_contents($_FILES['archivo']['tmp_name']));
                    if (
                        Validar::fecha($contrato->fechaInicio, '/', 'mda') && Validar::fecha($contrato->fechaFin, '/', 'mda') && Validar::patronalfanumerico1($contrato->titulo) &&
                        Validar::patronalfanumerico1($contrato->representante) && Validar::numeros($contrato->telefono) && Validar::correo($contrato->email) &&
                        Validar::tipoarchivo($contrato->contenType, 1)
                    ) {
                        $contrato->createContrato();
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
        $contrato = new Contrato($db);

        $contrato->draw = htmlspecialchars($_POST['draw']);
        $contrato->row = htmlspecialchars($_POST['start']);
        $contrato->rowperpage = htmlspecialchars($_POST['length']);
        $contrato->columnIndex = htmlspecialchars($_POST['order'][0]['column']);
        $contrato->columnName = htmlspecialchars($_POST['columns'][$contrato->columnIndex]['data']);
        $contrato->columnSortOrder = htmlspecialchars($_POST['order'][0]['dir']);
        $contrato->searchValue = htmlspecialchars($_POST['search']['value']);

        $contrato->readAllDaTableContrato();
    }

    public function getFile(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $contrato = new Contrato($db);

        // --Seteo de valores existentes en el POST--
        $contrato->id = isset($_POST['idContrato']) ? strtoupper(trim($_POST['idContrato'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($contrato->id)) {
            $contrato->traerArchivo();
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
        $contrato = new Contrato($db);

        // --Seteo de valores existentes en el POST--
        $contrato->id = isset($_POST['idContrato']) ? strtoupper(trim($_POST['idContrato'])) : NULL;
        $contrato->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        if (Validar::numeros($contrato->id) && Validar::numeros($contrato->status)) {
            $contrato->statusContrato();
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
        $contrato = new Contrato($db);

        // --Seteo de valores existentes en el POST--
        $contrato->id = isset($_POST['idContrato']) ? strtoupper(trim($_POST['idContrato'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($contrato->id)) {
            $contrato->dataContrato();
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
        $contrato = new Contrato($db);

        // --Seteo de valores existentes en el POST--
        $contrato->id = isset($_POST['idContrato']) ? trim($_POST['idContrato']) : NULL;
        $contrato->fechaInicio = isset($_POST['fechaInicio']) ? trim($_POST['fechaInicio']) : NULL;
        $contrato->fechaFin = isset($_POST['fechaFin']) ? trim($_POST['fechaFin']) : NULL;
        $contrato->titulo = isset($_POST['titulo']) ? strtoupper(trim($_POST['titulo'])) : NULL;
        $contrato->representante = isset($_POST['representante']) ? strtoupper(trim($_POST['representante'])) : NULL;
        $contrato->telefono = isset($_POST['telefono']) ? strtoupper(trim($_POST['telefono'])) : NULL;
        $contrato->email = isset($_POST['email']) ? strtoupper(trim($_POST['email'])) : NULL;
        $contrato->contenType = isset($_POST['contenType']) ? trim($_POST['contenType']) : NULL;
        $contrato->base64 = isset($_POST['base64']) ? trim($_POST['base64']) : NULL;

        if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {
            // --Verificacion de Archivo--
            if ($_FILES['archivo']['error'] != 0) {
                // --Archivo Corrupto--
                echo json_encode(array('status' => '4', 'data' => NULL));
            } else {
                if ($_FILES['archivo']['size'] <= 4000000) {
                    $contrato->contenType = $_FILES['archivo']['type'];
                    $contrato->base64 = base64_encode(file_get_contents($_FILES['archivo']['tmp_name']));
                    if (
                        Validar::fecha($contrato->fechaInicio, '/', 'mda') && Validar::fecha($contrato->fechaFin, '/', 'mda') && Validar::patronalfanumerico1($contrato->titulo) &&
                        Validar::patronalfanumerico1($contrato->representante) && Validar::numeros($contrato->telefono) && Validar::correo($contrato->email) &&
                        Validar::tipoarchivo($contrato->contenType, 1) && Validar::numeros($contrato->id)
                    ) {
                        $contrato->updateContrato();
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
                Validar::fecha($contrato->fechaInicio, '/', 'mda') && Validar::fecha($contrato->fechaFin, '/', 'mda') && Validar::patronalfanumerico1($contrato->titulo) &&
                Validar::patronalfanumerico1($contrato->representante) && Validar::numeros($contrato->telefono) && Validar::correo($contrato->email) &&
                Validar::numeros($contrato->id)
            ) {
                $contrato->updateContrato();
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
        $contrato = new Contrato($db);

        // --Seteo de valores existentes en el POST--
        $contrato->id = isset($_POST['idContrato']) ? strtoupper(trim($_POST['idContrato'])) : NULL;

        if (Validar::numeros($contrato->id)) {
            $contrato->deleteContrato();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
