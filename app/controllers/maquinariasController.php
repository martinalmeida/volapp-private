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
        $maquinaria->nombre = isset($_POST['nombre']) ? strtoupper(trim($_POST['nombre'])) : NULL;
        $maquinaria->fechaSoat = isset($_POST['fechaSoat']) ? trim($_POST['fechaSoat']) : NULL;
        $maquinaria->fechaLicencia = isset($_POST['fechaLicencia']) ? trim($_POST['fechaLicencia']) : NULL;
        $maquinaria->fecchaTdr = isset($_POST['fecchaTdr']) ? trim($_POST['fecchaTdr']) : NULL;

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
                        Validar::patronalfanumerico1($maquinaria->nombre) && Validar::fecha($maquinaria->fechaSoat, '/', 'mda') && Validar::fecha($maquinaria->fechaLicencia, '/', 'mda') &&
                        Validar::fecha($maquinaria->fecchaTdr, '/', 'mda') && Validar::tipoarchivo($maquinaria->contenType, 1)
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

        $maquinaria->readAllDaTableMaquinarias();
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
        $maquinaria->nombre = isset($_POST['nombre']) ? strtoupper(trim($_POST['nombre'])) : NULL;
        $maquinaria->fechaSoat = isset($_POST['fechaSoat']) ? trim($_POST['fechaSoat']) : NULL;
        $maquinaria->fechaLicencia = isset($_POST['fechaLicencia']) ? trim($_POST['fechaLicencia']) : NULL;
        $maquinaria->fecchaTdr = isset($_POST['fecchaTdr']) ? trim($_POST['fecchaTdr']) : NULL;
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
                        Validar::alfanumerico($maquinaria->nombre) && Validar::fecha($maquinaria->fechaSoat, '/', 'mda') && Validar::fecha($maquinaria->fechaLicencia, '/', 'mda') &&
                        Validar::fecha($maquinaria->fecchaTdr, '/', 'mda') && Validar::tipoarchivo($maquinaria->contenType, 1) && Validar::numeros($maquinaria->id)
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
                Validar::alfanumerico($maquinaria->nombre) && Validar::fecha($maquinaria->fechaSoat, '/', 'mda') && Validar::fecha($maquinaria->fechaLicencia, '/', 'mda') &&
                Validar::fecha($maquinaria->fecchaTdr, '/', 'mda') && Validar::numeros($maquinaria->id)
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
