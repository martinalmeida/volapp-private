<?php

declare(strict_types=1);

header('Content-type: application/json');

include(LIBRARIES . 'validations.php');
include(MODELS . 'modelUsuarios.php');

class UsuariosController
{
    public function read(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $usuario = new Usuario($db);

        $usuario->getReadPermisos();
    }

    public function write(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $usuario = new Usuario($db);

        $usuario->getWritePermisos();
    }

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
        $usuario->Apaterno = isset($_POST['Apaterno']) ? strtoupper(trim($_POST['Apaterno'])) : NULL;
        $usuario->Amaterno = isset($_POST['Amaterno']) ? strtoupper(trim($_POST['Amaterno'])) : NULL;
        $usuario->telefono = isset($_POST['telefono']) ? strtoupper(trim($_POST['telefono'])) : NULL;
        $usuario->emailUser = isset($_POST['emailUser']) ? strtoupper(trim($_POST['emailUser'])) : NULL;
        $usuario->pswd = isset($_POST['pswd']) ? strtoupper(trim($_POST['pswd'])) : NULL;
        $usuario->nombreFiscal = isset($_POST['nombreFiscal']) ? strtoupper(trim($_POST['nombreFiscal'])) : NULL;
        $usuario->direccionFiscal = isset($_POST['direccionFiscal']) ? strtoupper(trim($_POST['direccionFiscal'])) : NULL;
        $usuario->rol = isset($_POST['rol']) ? strtoupper(trim($_POST['rol'])) : NULL;
        $usuario->sucursal = isset($_POST['sucursal']) ? strtoupper(trim($_POST['sucursal'])) : NULL;

        if (is_uploaded_file($_FILES['logo']['tmp_name'])) {
            // --Verificacion de Archivo--
            if ($_FILES['logo']['error'] != 0) {
                // --Archivo Corrupto--
                echo json_encode(array('status' => '4', 'data' => NULL));
            } else {
                if ($_FILES['logo']['size'] < 2242880) {
                    $usuario->contenType = $_FILES['logo']['type'];
                    $usuario->base64 = base64_encode(file_get_contents($_FILES['logo']['tmp_name']));
                    if (
                        Validar::numeros($usuario->identificacion) && Validar::alfanumerico($usuario->nombres) && Validar::alfanumerico($usuario->Apaterno) &&
                        Validar::alfanumerico($usuario->Amaterno) && Validar::numeros($usuario->telefono) && Validar::correo($usuario->emailUser) &&
                        Validar::password($usuario->pswd) && Validar::alfanumerico($usuario->nombreFiscal) && Validar::direccion($usuario->direccionFiscal) &&
                        Validar::numeros($usuario->rol) && Validar::numeros($usuario->sucursal) && Validar::tipoarchivo($usuario->contenType, 7)
                    ) {
                        $usuario->createUsuario();
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
        $usuario = new Usuario($db);

        $usuario->draw = htmlspecialchars($_POST['draw']);
        $usuario->row = htmlspecialchars($_POST['start']);
        $usuario->rowperpage = htmlspecialchars($_POST['length']);
        $usuario->columnIndex = htmlspecialchars($_POST['order'][0]['column']);
        $usuario->columnName = htmlspecialchars($_POST['columns'][$usuario->columnIndex]['data']);
        $usuario->columnSortOrder = htmlspecialchars($_POST['order'][0]['dir']);
        $usuario->searchValue = htmlspecialchars($_POST['search']['value']);

        $usuario->readAllDaTableUsario();
    }

    public function status(): void
    {
        // --Importacion e inicializacion de conexion--
        include_once(DB);
        $database = new Database();
        $db = $database->getConnection();
        $usuario = new Usuario($db);

        // --Seteo de valores existentes en el POST--
        $usuario->id = isset($_POST['idUser']) ? strtoupper(trim($_POST['idUser'])) : NULL;
        $usuario->status = isset($_POST['status']) ? strtoupper(trim($_POST['status'])) : NULL;

        if (Validar::numeros($usuario->id) && Validar::numeros($usuario->status)) {
            $usuario->statusUsuario();
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
        $usuario = new Usuario($db);

        // --Seteo de valores existentes en el POST--
        $usuario->id = isset($_POST['idUser']) ? strtoupper(trim($_POST['idUser'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($usuario->id)) {
            $usuario->dataUsuario();
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
        $usuario = new Usuario($db);

        // --Seteo de valores existentes en el POST--
        $usuario->identificacion = isset($_POST['identificacion']) ? strtoupper(trim($_POST['identificacion'])) : NULL;
        $usuario->nombres = isset($_POST['nombres']) ? strtoupper(trim($_POST['nombres'])) : NULL;
        $usuario->Apaterno = isset($_POST['Apaterno']) ? strtoupper(trim($_POST['Apaterno'])) : NULL;
        $usuario->Amaterno = isset($_POST['Amaterno']) ? strtoupper(trim($_POST['Amaterno'])) : NULL;
        $usuario->telefono = isset($_POST['telefono']) ? strtoupper(trim($_POST['telefono'])) : NULL;
        $usuario->emailUser = isset($_POST['emailUser']) ? strtoupper(trim($_POST['emailUser'])) : NULL;
        $usuario->pswd = isset($_POST['pswd']) ? strtoupper(trim($_POST['pswd'])) : NULL;
        $usuario->nombreFiscal = isset($_POST['nombreFiscal']) ? strtoupper(trim($_POST['nombreFiscal'])) : NULL;
        $usuario->direccionFiscal = isset($_POST['direccionFiscal']) ? strtoupper(trim($_POST['direccionFiscal'])) : NULL;
        $usuario->contenType = isset($_POST['contenType']) ? trim($_POST['contenType']) : NULL;
        $usuario->base64 = isset($_POST['base64']) ? trim($_POST['base64']) : NULL;
        $usuario->rol = isset($_POST['rol']) ? strtoupper(trim($_POST['rol'])) : NULL;
        $usuario->sucursal = isset($_POST['sucursal']) ? strtoupper(trim($_POST['sucursal'])) : NULL;
        $usuario->id = isset($_POST['idUser']) ? strtoupper(trim($_POST['idUser'])) : NULL;

        if (is_uploaded_file($_FILES['logo']['tmp_name'])) {
            // --Verificacion de Archivo--
            if ($_FILES['logo']['error'] != 0) {
                // --Archivo Corrupto--
                echo json_encode(array('status' => '4', 'data' => NULL));
            } else {
                if ($_FILES['logo']['size'] < 2242880) {
                    $usuario->contenType = $_FILES['logo']['type'];
                    $usuario->base64 = base64_encode(file_get_contents($_FILES['logo']['tmp_name']));
                    if (
                        Validar::numeros($usuario->identificacion) && Validar::alfanumerico($usuario->nombres) && Validar::alfanumerico($usuario->Apaterno) &&
                        Validar::alfanumerico($usuario->Amaterno) && Validar::numeros($usuario->telefono) && Validar::correo($usuario->emailUser) &&
                        Validar::password($usuario->pswd) && Validar::alfanumerico($usuario->nombreFiscal) && Validar::direccion($usuario->direccionFiscal) &&
                        Validar::numeros($usuario->rol) && Validar::numeros($usuario->sucursal) && Validar::tipoarchivo($usuario->contenType, 7)
                    ) {
                        $usuario->updateUsuario();
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
                Validar::numeros($usuario->identificacion) && Validar::alfanumerico($usuario->nombres) && Validar::alfanumerico($usuario->Apaterno) &&
                Validar::alfanumerico($usuario->Amaterno) && Validar::numeros($usuario->telefono) && Validar::correo($usuario->emailUser) &&
                Validar::password($usuario->pswd) && Validar::alfanumerico($usuario->nombreFiscal) && Validar::direccion($usuario->direccionFiscal) &&
                Validar::numeros($usuario->rol) && Validar::numeros($usuario->sucursal)
            ) {
                $usuario->updateUsuario();
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
        $usuario = new Usuario($db);

        // --Seteo de valores existentes en el POST--
        $usuario->id = isset($_POST['idUser']) ? strtoupper(trim($_POST['idUser'])) : NULL;

        if (Validar::numeros($usuario->id)) {
            $usuario->deleteUsuario();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
