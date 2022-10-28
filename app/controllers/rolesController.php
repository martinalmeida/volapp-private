<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(MODELS . 'modelRoles.php');

class RolesController
{
    public function create(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $rol = new Rol($db);

        // --Seteo de valores existentes en el POST--
        $rol->nombrerol = isset($_POST['nombrerol']) ? strtoupper(trim($_POST['nombrerol'])) : NULL;
        $rol->descripcion = isset($_POST['descripcion']) ? strtoupper(trim($_POST['descripcion'])) : NULL;

        if (Validar::alfanumerico($rol->nombrerol) && Validar::alfanumerico($rol->descripcion)) {
            $rol->createRol();
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
        $rol = new Rol($db);

        $rol->draw = htmlspecialchars($_POST['draw']);
        $rol->row = htmlspecialchars($_POST['start']);
        $rol->rowperpage = htmlspecialchars($_POST['length']);
        $rol->columnIndex = htmlspecialchars($_POST['order'][0]['column']);
        $rol->columnName = htmlspecialchars($_POST['columns'][$rol->columnIndex]['data']);
        $rol->columnSortOrder = htmlspecialchars($_POST['order'][0]['dir']);
        $rol->searchValue = htmlspecialchars($_POST['search']['value']);

        $rol->readAllDaTableRol();
    }

    public function status(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $rol = new Rol($db);

        // --Seteo de valores existentes en el POST--
        $rol->id = isset($_POST['idRol']) ? strtoupper(trim($_POST['idRol'])) : NULL;
        $rol->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        if (Validar::numeros($rol->id) && Validar::numeros($rol->status)) {
            $rol->statusRol();
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
        $rol = new Rol($db);

        // --Seteo de valores existentes en el POST--
        $rol->id = isset($_POST['idRol']) ? strtoupper(trim($_POST['idRol'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($rol->id)) {
            $rol->dataRol();
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
        $rol = new Rol($db);

        // --Seteo de valores existentes en el POST--
        $rol->id = isset($_POST['idRol']) ? strtoupper(trim($_POST['idRol'])) : NULL;
        $rol->nombrerol = isset($_POST['nombrerol']) ? strtoupper(trim($_POST['nombrerol'])) : NULL;
        $rol->descripcion = isset($_POST['descripcion']) ? strtoupper(trim($_POST['descripcion'])) : NULL;


        if (Validar::numeros($rol->id) && Validar::alfanumerico($rol->nombrerol) && Validar::alfanumerico($rol->descripcion)) {
            $rol->updateRol();
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
        $rol = new Rol($db);

        // --Seteo de valores existentes en el POST--
        $rol->id = isset($_POST['idRol']) ? strtoupper(trim($_POST['idRol'])) : NULL;

        if (Validar::numeros($rol->id)) {
            $rol->deleteRol();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
