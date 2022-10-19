<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(MODELS . 'modelUsuarios.php');

class UsuariosController
{
    public function create(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $usuario = new Usuario($db);

        // --Seteo de valores existentes en el POST--
        $usuario->identificacion = isset($_POST['identificacion']) ? strtoupper(trim($_POST['identificacion'])) : NULL;
        $usuario->nombres = isset($_POST['nombres']) ? strtoupper(trim($_POST['nombres'])) : NULL;
        $usuario->a_paterno = isset($_POST['a_paterno']) ? strtoupper(trim($_POST['a_paterno'])) : NULL;
        $usuario->a_materno = isset($_POST['a_materno']) ? strtoupper(trim($_POST['a_materno'])) : NULL;
        $usuario->telefono = isset($_POST['telefono']) ? strtoupper(trim($_POST['telefono'])) : NULL;
        $usuario->email_user = isset($_POST['email_user']) ? strtoupper(trim($_POST['email_user'])) : NULL;
        $usuario->pswd = isset($_POST['pswd']) ? strtoupper(trim($_POST['pswd'])) : NULL;
        $usuario->ruc = isset($_POST['ruc']) ? strtoupper(trim($_POST['ruc'])) : NULL;
        $usuario->nombrefiscal = isset($_POST['nombrefiscal']) ? strtoupper(trim($_POST['nombrefiscal'])) : NULL;
        $usuario->direccionfiscal = isset($_POST['direccionfiscal']) ? strtoupper(trim($_POST['direccionfiscal'])) : NULL;
        $usuario->rolid = isset($_POST['rolid']) ? strtoupper(trim($_POST['rolid'])) : NULL;
        $usuario->datecreated = isset($_POST['datecreated']) ? strtoupper(trim($_POST['datecreated'])) : NULL;
        $usuario->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        $usuario->createUsuario();
    }

    public function update(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $usuario = new Usuario($db);

        // --Seteo de valores existentes en el POST--
        $usuario->identificacion = isset($_POST['identificacion']) ? strtoupper(trim($_POST['identificacion'])) : NULL;
        $usuario->nombres = isset($_POST['nombres']) ? strtoupper(trim($_POST['nombres'])) : NULL;
        $usuario->a_paterno = isset($_POST['a_paterno']) ? strtoupper(trim($_POST['a_paterno'])) : NULL;
        $usuario->a_materno = isset($_POST['a_materno']) ? strtoupper(trim($_POST['a_materno'])) : NULL;
        $usuario->telefono = isset($_POST['telefono']) ? strtoupper(trim($_POST['telefono'])) : NULL;
        $usuario->email_user = isset($_POST['email_user']) ? strtoupper(trim($_POST['email_user'])) : NULL;
        $usuario->pswd = isset($_POST['pswd']) ? strtoupper(trim($_POST['pswd'])) : NULL;
        $usuario->ruc = isset($_POST['ruc']) ? strtoupper(trim($_POST['ruc'])) : NULL;
        $usuario->nombrefiscal = isset($_POST['nombrefiscal']) ? strtoupper(trim($_POST['nombrefiscal'])) : NULL;
        $usuario->direccionfiscal = isset($_POST['direccionfiscal']) ? strtoupper(trim($_POST['direccionfiscal'])) : NULL;
        $usuario->rolid = isset($_POST['rolid']) ? strtoupper(trim($_POST['rolid'])) : NULL;
        $usuario->datecreated = isset($_POST['datecreated']) ? strtoupper(trim($_POST['datecreated'])) : NULL;
        $usuario->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;
        $usuario->id = isset($_POST['id']) ? strtoupper(trim($_POST['id'])) : NULL;

        $usuario->updateUsuario();
    }

    public function delete(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $usuario = new Usuario($db);

        // --Seteo de valores existentes en el POST--
        $usuario->id = isset($_POST['id']) ? strtoupper(trim($_POST['id'])) : NULL;

        $usuario->deleteUsuario();
    }

    public function status(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $usuario = new Usuario($db);

        // --Seteo de valores existentes en el POST--
        $usuario->id = isset($_POST['idRegistro']) ? strtoupper(trim($_POST['idRegistro'])) : NULL;
        $usuario->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        $usuario->statusUsuario();
    }

    # objetos de Datatables para utilizar (Serverside)
    public function readAllDaTable(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $usuario = new Usuario($db);

        $usuario->draw = htmlspecialchars($_POST['draw']);
        $usuario->row = htmlspecialchars($_POST['start']);
        $usuario->rowperpage = htmlspecialchars($_POST['length']);
        $usuario->columnIndex = htmlspecialchars($_POST['order'][0]['column']);
        $usuario->columnName = htmlspecialchars($_POST['columns'][$usuario->columnIndex]['data']);
        $usuario->columnSortOrder = htmlspecialchars($_POST['order'][0]['dir']);
        $usuario->searchValue = htmlspecialchars($_POST['search']['value']);

        $usuario->readAllDaTableUsuario();
    }
}
