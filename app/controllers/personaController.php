<?php

declare(strict_types=1);

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

        $identificacion = '1096251410';
        $nombres = 'jhonny';
        $a_paterno = 'bravo';
        $a_materno = 'si señor';
        $telefono = '3115706925';
        $email_user = 'jgomez1genio@gmail.com';
        $password = '124351hdbf';
        $ruc = '4857jj';
        $nombrefiscal = 'priuena';
        $direccionfiscal = 'dddssd';
        $rolid = '1';
        $datecreated = '2008-01-01 00:00:01';
        $status = '2';

        // --Seteo de valores existentes en el POST--
        $persona->identificacion = isset($identificacion) ? strtoupper(trim($identificacion)) : NULL;
        $persona->nombres = isset($nombres) ? strtoupper(trim($nombres)) : NULL;
        $persona->a_paterno = isset($a_paterno) ? strtoupper(trim($a_paterno)) : NULL;
        $persona->a_materno = isset($a_materno) ? strtoupper(trim($a_materno)) : NULL;
        $persona->telefono = isset($telefono) ? strtoupper(trim($telefono)) : NULL;
        $persona->email_user = isset($email_user) ? strtoupper(trim($email_user)) : NULL;
        $persona->password = isset($password) ? strtoupper(trim($password)) : NULL;
        $persona->ruc = isset($ruc) ? strtoupper(trim($ruc)) : NULL;
        $persona->nombrefiscal = isset($nombrefiscal) ? strtoupper(trim($nombrefiscal)) : NULL;
        $persona->direccionfiscal = isset($direccionfiscal) ? strtoupper(trim($direccionfiscal)) : NULL;
        $persona->rolid = isset($rolid) ? strtoupper(trim($rolid)) : NULL;
        $persona->datecreated = isset($datecreated) ? strtoupper(trim($datecreated)) : NULL;
        $persona->status = isset($status) ? strtoupper(trim($status)) : NULL;


        $data = $persona->createPersona();
        echo json_encode($data);
    }

    public function update(): void
    {
        // --Importacion e inicializacion de conexion--
        include($_SERVER['DOCUMENT_ROOT'] . INC . 'db.php');
        $database = new Database();
        $db = $database->getConnection();
        $persona = new Persona($db);

        $identificacion = '1096251410';
        $nombres = 'jonathan';
        $a_paterno = 'contento';
        $a_materno = 'si señor';
        $telefono = '3115706925';
        $email_user = 'jgomez1genio@gmail.com';
        $password = '124351hdbf';
        $ruc = '4857jj';
        $nombrefiscal = 'siii';
        $direccionfiscal = 'dddssd';
        $rolid = '1';
        $datecreated = '2008-01-01 00:00:01';
        $status = '2';
        $id = '3';

        // --Seteo de valores existentes en el POST--
        $persona->identificacion = isset($identificacion) ? strtoupper(trim($identificacion)) : NULL;
        $persona->nombres = isset($nombres) ? strtoupper(trim($nombres)) : NULL;
        $persona->a_paterno = isset($a_paterno) ? strtoupper(trim($a_paterno)) : NULL;
        $persona->a_materno = isset($a_materno) ? strtoupper(trim($a_materno)) : NULL;
        $persona->telefono = isset($telefono) ? strtoupper(trim($telefono)) : NULL;
        $persona->email_user = isset($email_user) ? strtoupper(trim($email_user)) : NULL;
        $persona->password = isset($password) ? strtoupper(trim($password)) : NULL;
        $persona->ruc = isset($ruc) ? strtoupper(trim($ruc)) : NULL;
        $persona->nombrefiscal = isset($nombrefiscal) ? strtoupper(trim($nombrefiscal)) : NULL;
        $persona->direccionfiscal = isset($direccionfiscal) ? strtoupper(trim($direccionfiscal)) : NULL;
        $persona->rolid = isset($rolid) ? strtoupper(trim($rolid)) : NULL;
        $persona->datecreated = isset($datecreated) ? strtoupper(trim($datecreated)) : NULL;
        $persona->status = isset($status) ? strtoupper(trim($status)) : NULL;
        $persona->id = isset($id) ? strtoupper(trim($id)) : NULL;


        $data = $persona->updatePersona();
        echo json_encode($data);

    }
}