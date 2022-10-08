<?php

declare(strict_types=1);
header('Content-type: application/json');

include_once($_SERVER['DOCUMENT_ROOT'] . '/volapp/inc/volappConfig.php');
include($_SERVER['DOCUMENT_ROOT'] . LIBRARIES . 'validations.php');
include($_SERVER['DOCUMENT_ROOT'] . MODELS . 'modelPersona.php');

class PersonaController
{
    public function create(): void
    {
        // --Importacion e inicializacion de conexion--
        include($_SERVER['DOCUMENT_ROOT'] . INC . 'db.php');
        $database = new Database();
        $db = $database->getConnection();
        $persona = new Persona($db);

        // --Seteo de valores existentes en el POST--
        $persona->identificacion = isset($_POST['identificacion']) ? strtoupper(trim($_POST['identificacion'])) : NULL;
        $persona->nombres = isset($_POST['nombres']) ? strtoupper(trim($_POST['nombres'])) : NULL;
        $persona->a_paterno = isset($_POST['a_paterno']) ? strtoupper(trim($_POST['a_paterno'])) : NULL;
        $persona->a_materno = isset($_POST['a_materno']) ? strtoupper(trim($_POST['a_materno'])) : NULL;
        $persona->telefono = isset($_POST['telefono']) ? strtoupper(trim($_POST['telefono'])) : NULL;
        $persona->email_user = isset($_POST['email_user']) ? strtoupper(trim($_POST['email_user'])) : NULL;
        $persona->pswd = isset($_POST['pswd']) ? strtoupper(trim($_POST['pswd'])) : NULL;
        $persona->ruc = isset($_POST['ruc']) ? strtoupper(trim($_POST['ruc'])) : NULL;
        $persona->nombrefiscal = isset($_POST['nombrefiscal']) ? strtoupper(trim($_POST['nombrefiscal'])) : NULL;
        $persona->direccionfiscal = isset($_POST['direccionfiscal']) ? strtoupper(trim($_POST['direccionfiscal'])) : NULL;
        $persona->rolid = isset($_POST['rolid']) ? strtoupper(trim($_POST['rolid'])) : NULL;
        $persona->datecreated = isset($_POST['datecreated']) ? strtoupper(trim($_POST['datecreated'])) : NULL;
        $persona->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        $persona->createPersona();
    }

    public function update(): void
    {
        // --Importacion e inicializacion de conexion--
        include($_SERVER['DOCUMENT_ROOT'] . INC . 'db.php');
        $database = new Database();
        $db = $database->getConnection();
        $persona = new Persona($db);

        // --Seteo de valores existentes en el POST--
        $persona->identificacion = isset($_POST['identificacion']) ? strtoupper(trim($_POST['identificacion'])) : NULL;
        $persona->nombres = isset($_POST['nombres']) ? strtoupper(trim($_POST['nombres'])) : NULL;
        $persona->a_paterno = isset($_POST['a_paterno']) ? strtoupper(trim($_POST['a_paterno'])) : NULL;
        $persona->a_materno = isset($_POST['a_materno']) ? strtoupper(trim($_POST['a_materno'])) : NULL;
        $persona->telefono = isset($_POST['telefono']) ? strtoupper(trim($_POST['telefono'])) : NULL;
        $persona->email_user = isset($_POST['email_user']) ? strtoupper(trim($_POST['email_user'])) : NULL;
        $persona->pswd = isset($_POST['pswd']) ? strtoupper(trim($_POST['pswd'])) : NULL;
        $persona->ruc = isset($_POST['ruc']) ? strtoupper(trim($_POST['ruc'])) : NULL;
        $persona->nombrefiscal = isset($_POST['nombrefiscal']) ? strtoupper(trim($_POST['nombrefiscal'])) : NULL;
        $persona->direccionfiscal = isset($_POST['direccionfiscal']) ? strtoupper(trim($_POST['direccionfiscal'])) : NULL;
        $persona->rolid = isset($_POST['rolid']) ? strtoupper(trim($_POST['rolid'])) : NULL;
        $persona->datecreated = isset($_POST['datecreated']) ? strtoupper(trim($_POST['datecreated'])) : NULL;
        $persona->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;
        $persona->id = isset($_POST['id']) ? strtoupper(trim($_POST['id'])) : NULL;

        $persona->updatePersona();
    }

    public function delete(): void
    {
        // --Importacion e inicializacion de conexion--
        include($_SERVER['DOCUMENT_ROOT'] . INC . 'db.php');
        $database = new Database();
        $db = $database->getConnection();
        $persona = new Persona($db);

        // --Seteo de valores existentes en el POST--
        $persona->id = isset($_POST['id']) ? strtoupper(trim($_POST['id'])) : NULL;

        $persona->deletePersona();
    }

    # objetos de Datatables para utilizar (Serverside)
    public function readAllDaTable(): void
    {
        // --Importacion e inicializacion de conexion--
        include($_SERVER['DOCUMENT_ROOT'] . INC . 'db.php');
        $database = new Database();
        $db = $database->getConnection();
        $persona = new Persona($db);

        $persona->draw = htmlspecialchars($_POST['draw']);
        $persona->row = htmlspecialchars($_POST['start']);
        $persona->rowperpage = htmlspecialchars($_POST['length']);
        $persona->columnIndex = htmlspecialchars($_POST['order'][0]['column']);
        $persona->columnName = htmlspecialchars($_POST['columns'][$persona->columnIndex]['data']);
        $persona->columnSortOrder = htmlspecialchars($_POST['order'][0]['dir']);
        $persona->searchValue = htmlspecialchars($_POST['search']['value']);

        $persona->readAllDaTablePerson();
    }
}