<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(MODELS . 'modelAlquiler.php');

class AlquilerController
{
    public function read(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $alquiler = new Alquiler($db);

        $alquiler->getReadPermisos();
    }

    public function write(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $alquiler = new Alquiler($db);

        $alquiler->getWritePermisos();
    }

    public function readAllDaTable(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $alquiler = new Alquiler($db);

        $alquiler->draw = htmlspecialchars($_POST['draw']);
        $alquiler->row = htmlspecialchars($_POST['start']);
        $alquiler->rowperpage = htmlspecialchars($_POST['length']);
        $alquiler->columnIndex = htmlspecialchars($_POST['order'][0]['column']);
        $alquiler->columnName = htmlspecialchars($_POST['columns'][$alquiler->columnIndex]['data']);
        $alquiler->columnSortOrder = htmlspecialchars($_POST['order'][0]['dir']);
        $alquiler->searchValue = htmlspecialchars($_POST['search']['value']);

        $alquiler->readAllDaTableContrato();
    }

    public function status(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $alquiler = new Alquiler($db);

        // --Seteo de valores existentes en el POST--
        $alquiler->id = isset($_POST['idContrato']) ? strtoupper(trim($_POST['idContrato'])) : NULL;
        $alquiler->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        if (Validar::numeros($alquiler->id) && Validar::numeros($alquiler->status)) {
            $alquiler->statusContrato();
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
        $alquiler = new Alquiler($db);

        // --Seteo de valores existentes en el POST--
        $alquiler->id = isset($_POST['idContrato']) ? strtoupper(trim($_POST['idContrato'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($alquiler->id)) {
            $alquiler->dataContrato();
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
        $alquiler = new Alquiler($db);

        // --Seteo de valores existentes en el POST--
        $alquiler->id = isset($_POST['idContrato']) ? trim($_POST['idContrato']) : NULL;
        $alquiler->fechaInicio = isset($_POST['fechaInicio']) ? trim($_POST['fechaInicio']) : NULL;
        $alquiler->fechaFin = isset($_POST['fechaFin']) ? trim($_POST['fechaFin']) : NULL;
        $alquiler->titulo = isset($_POST['titulo']) ? strtoupper(trim($_POST['titulo'])) : NULL;
        $alquiler->representante = isset($_POST['representante']) ? strtoupper(trim($_POST['representante'])) : NULL;
        $alquiler->telefono = isset($_POST['telefono']) ? strtoupper(trim($_POST['telefono'])) : NULL;
        $alquiler->email = isset($_POST['email']) ? strtoupper(trim($_POST['email'])) : NULL;
        $alquiler->contenType = isset($_POST['contenType']) ? trim($_POST['contenType']) : NULL;
        $alquiler->base64 = isset($_POST['base64']) ? trim($_POST['base64']) : NULL;

        if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {
            // --Verificacion de Archivo--
            if ($_FILES['archivo']['error'] != 0) {
                // --Archivo Corrupto--
                echo json_encode(array('status' => '4', 'data' => NULL));
            } else {
                if ($_FILES['archivo']['size'] < 10242880) {
                    $alquiler->contenType = $_FILES['archivo']['type'];
                    $alquiler->base64 = base64_encode(file_get_contents($_FILES['archivo']['tmp_name']));
                    if (
                        Validar::fecha($alquiler->fechaInicio, '/', 'mda') && Validar::fecha($alquiler->fechaFin, '/', 'mda') && Validar::patronalfanumerico1($alquiler->titulo) &&
                        Validar::patronalfanumerico1($alquiler->representante) && Validar::numeros($alquiler->telefono) && Validar::correo($alquiler->email) &&
                        Validar::tipoarchivo($alquiler->contenType, 1) && Validar::numeros($alquiler->id)
                    ) {
                        $alquiler->updateContrato();
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
                Validar::fecha($alquiler->fechaInicio, '/', 'mda') && Validar::fecha($alquiler->fechaFin, '/', 'mda') && Validar::patronalfanumerico1($alquiler->titulo) &&
                Validar::patronalfanumerico1($alquiler->representante) && Validar::numeros($alquiler->telefono) && Validar::correo($alquiler->email) &&
                Validar::numeros($alquiler->id)
            ) {
                $alquiler->updateContrato();
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
        $alquiler = new Alquiler($db);

        // --Seteo de valores existentes en el POST--
        $alquiler->id = isset($_POST['idContrato']) ? strtoupper(trim($_POST['idContrato'])) : NULL;

        if (Validar::numeros($alquiler->id)) {
            $alquiler->deleteContrato();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
