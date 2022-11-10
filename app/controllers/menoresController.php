<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(MODELS . 'modelMenores.php');

class MenoresController
{
    public function read(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $menores = new EquipoMenor($db);

        $menores->getReadPermisos();
    }

    public function write(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $menores = new EquipoMenor($db);

        $menores->getWritePermisos();
    }

    public function create(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $menores = new EquipoMenor($db);

        // --Seteo de valores existentes en el POST--
        $menores->nombre = isset($_POST['nombre']) ? strtoupper(trim($_POST['nombre'])) : NULL;

        if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {
            // --Verificacion de Archivo--
            if ($_FILES['archivo']['error'] != 0) {
                // --Archivo Corrupto--
                echo json_encode(array('status' => '4', 'data' => NULL));
            } else {
                if ($_FILES['archivo']['size'] < 10242880) {
                    $menores->contenType = $_FILES['archivo']['type'];
                    $menores->base64 = base64_encode(file_get_contents($_FILES['archivo']['tmp_name']));
                    if (
                        Validar::patronalfanumerico1($menores->nombre) && Validar::tipoarchivo($menores->contenType, 1)
                    ) {
                        $menores->createEquipo();
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
        $menores = new EquipoMenor($db);

        $menores->draw = htmlspecialchars($_POST['draw']);
        $menores->row = htmlspecialchars($_POST['start']);
        $menores->rowperpage = htmlspecialchars($_POST['length']);
        $menores->columnIndex = htmlspecialchars($_POST['order'][0]['column']);
        $menores->columnName = htmlspecialchars($_POST['columns'][$menores->columnIndex]['data']);
        $menores->columnSortOrder = htmlspecialchars($_POST['order'][0]['dir']);
        $menores->searchValue = htmlspecialchars($_POST['search']['value']);

        $menores->readAllDaTableMenores();
    }

    public function status(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $menores = new EquipoMenor($db);

        // --Seteo de valores existentes en el POST--
        $menores->id = isset($_POST['idMenor']) ? strtoupper(trim($_POST['idMenor'])) : NULL;
        $menores->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        if (Validar::numeros($menores->id) && Validar::numeros($menores->status)) {
            $menores->statusEquipo();
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
        $menores = new EquipoMenor($db);

        // --Seteo de valores existentes en el POST--
        $menores->id = isset($_POST['idMenor']) ? trim($_POST['idMenor']) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($menores->id)) {
            $menores->dataEquipo();
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
        $menores = new EquipoMenor($db);

        // --Seteo de valores existentes en el POST--
        $menores->id = isset($_POST['idMenor']) ? trim($_POST['idMenor']) : NULL;
        $menores->nombre = isset($_POST['nombre']) ? strtoupper(trim($_POST['nombre'])) : NULL;
        $menores->contenType = isset($_POST['contenType']) ? trim($_POST['contenType']) : NULL;
        $menores->base64 = isset($_POST['base64']) ? trim($_POST['base64']) : NULL;

        if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {
            // --Verificacion de Archivo--
            if ($_FILES['archivo']['error'] != 0) {
                // --Archivo Corrupto--
                echo json_encode(array('status' => '4', 'data' => NULL));
            } else {
                if ($_FILES['archivo']['size'] < 10242880) {
                    $menores->contenType = $_FILES['archivo']['type'];
                    $menores->base64 = base64_encode(file_get_contents($_FILES['archivo']['tmp_name']));
                    if (
                        Validar::alfanumerico($menores->nombre) && Validar::tipoarchivo($menores->contenType, 1) && Validar::numeros($menores->id)
                    ) {
                        $menores->updateMenores();
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
                Validar::alfanumerico($menores->nombre) &&  Validar::numeros($menores->id)
            ) {
                $menores->updateMenores();
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
        $menores = new EquipoMenor($db);

        // --Seteo de valores existentes en el POST--
        $menores->id = isset($_POST['idMenor']) ? strtoupper(trim($_POST['idMenor'])) : NULL;

        if (Validar::numeros($menores->id)) {
            $menores->deleteMenor();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
