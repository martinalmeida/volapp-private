<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(MODELS . 'modelEmpresas.php');

class EmpresasController
{
    public function create(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $empresa = new Empresa($db);

        // --Seteo de valores existentes en el POST--
        $empresa->nit = isset($_POST['nit']) ? strtoupper(trim($_POST['nit'])) : NULL;
        $empresa->digito = isset($_POST['digito']) ? strtoupper(trim($_POST['digito'])) : NULL;
        $empresa->nombre = isset($_POST['nombre']) ? strtoupper(trim($_POST['nombre'])) : NULL;
        $empresa->representante = isset($_POST['representante']) ? strtoupper(trim($_POST['representante'])) : NULL;
        $empresa->telefono = isset($_POST['telefono']) ? strtoupper(trim($_POST['telefono'])) : NULL;
        $empresa->direccion = isset($_POST['direccion']) ? strtoupper(trim($_POST['direccion'])) : NULL;
        $empresa->correo = isset($_POST['correo']) ? strtoupper(trim($_POST['correo'])) : NULL;
        $empresa->contacto = isset($_POST['contacto']) ? strtoupper(trim($_POST['contacto'])) : NULL;
        $empresa->emailTec = isset($_POST['emailTec']) ? strtoupper(trim($_POST['emailTec'])) : NULL;
        $empresa->emailLogis = isset($_POST['emailLogis']) ? strtoupper(trim($_POST['emailLogis'])) : NULL;

        if (is_uploaded_file($_FILES['logo']['tmp_name'])) {
            // --Verificacion de Archivo--
            if ($_FILES['logo']['error'] != 0) {
                // --Archivo Corrupto--
                echo json_encode(array('status' => '4', 'data' => NULL));
            } else {
                if ($_FILES['logo']['size'] < 2242880) {
                    $empresa->contenType = $_FILES['logo']['type'];
                    $empresa->base64 = base64_encode(file_get_contents($_FILES['logo']['tmp_name']));
                    if (
                        validar::numeros($empresa->nit) && validar::numeros($empresa->digito) && validar::alfanumerico($empresa->nombre) &&
                        validar::alfanumerico($empresa->representante) && validar::numeros($empresa->telefono) && validar::alfanumerico($empresa->direccion) &&
                        validar::correo($empresa->correo) && validar::numeros($empresa->contacto) && validar::correo($empresa->emailTec) &&
                        validar::correo($empresa->emailLogis) && validar::tipoarchivo($empresa->contenType, 7)
                    ) {
                        $empresa->createEmpresa();
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
        $empresa = new Empresa($db);

        $empresa->draw = htmlspecialchars($_POST['draw']);
        $empresa->row = htmlspecialchars($_POST['start']);
        $empresa->rowperpage = htmlspecialchars($_POST['length']);
        $empresa->columnIndex = htmlspecialchars($_POST['order'][0]['column']);
        $empresa->columnName = htmlspecialchars($_POST['columns'][$empresa->columnIndex]['data']);
        $empresa->columnSortOrder = htmlspecialchars($_POST['order'][0]['dir']);
        $empresa->searchValue = htmlspecialchars($_POST['search']['value']);

        $empresa->readAllDaTableEmpresa();
    }

    public function status(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $empresa = new Empresa($db);

        // --Seteo de valores existentes en el POST--
        $empresa->nit = isset($_POST['nitEmpresa']) ? strtoupper(trim($_POST['nitEmpresa'])) : NULL;
        $empresa->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        $empresa->statusEmpresa();
    }

    // public function update(): void
    // {
    //     // --Importacion e inicializacion de conexion--
    //     include_once(DB);
    //     $database = new Database();
    //     $db = $database->getConnection();
    //     $empresa = new Empresa($db);

    //     // --Seteo de valores existentes en el POST--
    //     $empresa->identificacion = isset($_POST['identificacion']) ? strtoupper(trim($_POST['identificacion'])) : NULL;
    //     $empresa->nombres = isset($_POST['nombres']) ? strtoupper(trim($_POST['nombres'])) : NULL;
    //     $empresa->a_paterno = isset($_POST['a_paterno']) ? strtoupper(trim($_POST['a_paterno'])) : NULL;
    //     $empresa->a_materno = isset($_POST['a_materno']) ? strtoupper(trim($_POST['a_materno'])) : NULL;
    //     $empresa->telefono = isset($_POST['telefono']) ? strtoupper(trim($_POST['telefono'])) : NULL;
    //     $empresa->email_user = isset($_POST['email_user']) ? strtoupper(trim($_POST['email_user'])) : NULL;
    //     $empresa->pswd = isset($_POST['pswd']) ? strtoupper(trim($_POST['pswd'])) : NULL;
    //     $empresa->ruc = isset($_POST['ruc']) ? strtoupper(trim($_POST['ruc'])) : NULL;
    //     $empresa->nombrefiscal = isset($_POST['nombrefiscal']) ? strtoupper(trim($_POST['nombrefiscal'])) : NULL;
    //     $empresa->direccionfiscal = isset($_POST['direccionfiscal']) ? strtoupper(trim($_POST['direccionfiscal'])) : NULL;
    //     $empresa->rolid = isset($_POST['rolid']) ? strtoupper(trim($_POST['rolid'])) : NULL;
    //     $empresa->datecreated = isset($_POST['datecreated']) ? strtoupper(trim($_POST['datecreated'])) : NULL;
    //     $empresa->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;
    //     $empresa->id = isset($_POST['id']) ? strtoupper(trim($_POST['id'])) : NULL;

    //     $empresa->updateUsuario();
    // }

    // public function delete(): void
    // {
    //     // --Importacion e inicializacion de conexion--
    //     include_once(DB);
    //     $database = new Database();
    //     $db = $database->getConnection();
    //     $usuario = new Usuario($db);

    //     // --Seteo de valores existentes en el POST--
    //     $usuario->id = isset($_POST['id']) ? strtoupper(trim($_POST['id'])) : NULL;

    //     $usuario->deleteUsuario();
    // }

}
