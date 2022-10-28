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
                        Validar::numeros($empresa->nit) && Validar::numeros($empresa->digito) && Validar::alfanumerico($empresa->nombre) &&
                        Validar::alfanumerico($empresa->representante) && Validar::numeros($empresa->telefono) && Validar::alfanumerico($empresa->direccion) &&
                        Validar::correo($empresa->correo) && Validar::numeros($empresa->contacto) && Validar::correo($empresa->emailTec) &&
                        Validar::correo($empresa->emailLogis) && Validar::tipoarchivo($empresa->contenType, 7)
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

        if (Validar::numeros($empresa->nit) && Validar::numeros($empresa->status)) {
            $empresa->statusEmpresa();
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
        $empresa = new Empresa($db);

        // --Seteo de valores existentes en el POST--
        $empresa->nit = isset($_POST['nitEmpresa']) ? strtoupper(trim($_POST['nitEmpresa'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (Validar::numeros($empresa->nit)) {
            $empresa->dataEmpresa();
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
        $empresa->contenType = isset($_POST['contenType']) ? trim($_POST['contenType']) : NULL;
        $empresa->base64 = isset($_POST['base64']) ? trim($_POST['base64']) : NULL;
        $empresa->id = isset($_POST['idEmpresa']) ? strtoupper(trim($_POST['idEmpresa'])) : NULL;

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
                        Validar::numeros($empresa->nit) && Validar::numeros($empresa->digito) && Validar::alfanumerico($empresa->nombre) &&
                        Validar::alfanumerico($empresa->representante) && Validar::numeros($empresa->telefono) && Validar::alfanumerico($empresa->direccion) &&
                        Validar::correo($empresa->correo) && Validar::numeros($empresa->contacto) && Validar::correo($empresa->emailTec) &&
                        Validar::correo($empresa->emailLogis) && Validar::tipoarchivo($empresa->contenType, 7) && Validar::numeros($empresa->id)
                    ) {
                        $empresa->updateEmpresa();
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
                Validar::numeros($empresa->nit) && Validar::numeros($empresa->digito) && Validar::alfanumerico($empresa->nombre) && Validar::alfanumerico($empresa->representante) &&
                Validar::numeros($empresa->telefono) && Validar::alfanumerico($empresa->direccion) && Validar::correo($empresa->correo) &&
                Validar::numeros($empresa->contacto) && Validar::correo($empresa->emailTec) && Validar::correo($empresa->emailLogis) && Validar::numeros($empresa->id)
            ) {
                $empresa->updateEmpresa();
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
        $empresa = new Empresa($db);

        // --Seteo de valores existentes en el POST--
        $empresa->nit = isset($_POST['nitEmpresa']) ? strtoupper(trim($_POST['nitEmpresa'])) : NULL;

        if (Validar::numeros($empresa->nit)) {
            $empresa->deleteEmpresa();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }
}
