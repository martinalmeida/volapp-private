<?php

declare(strict_types=1);

include_once($_SERVER['DOCUMENT_ROOT'] . '/volapp/inc/volappConfig.php');
include_once($_SERVER['DOCUMENT_ROOT'] . LIBRARIES . 'sesion.php');

class LoginController
{
    public function getUser(): void
    {
        // --Importacion e inicializacion de conexion--
        include($_SERVER['DOCUMENT_ROOT'] . INC . 'db.php');
        $database = new Database();
        $db = $database->getConnection();
        $login = new Login($db);

        // --Seteo de valores existentes en el POST--
        $login->correo = isset($_POST['usuarioLogin']) ? strtoupper(trim($_POST['usuarioLogin'])) : NULL;
        $login->password = isset($_POST['contraseniaLogin']) ? strtoupper(trim($_POST['contraseniaLogin'])) : NULL;

        // --Validacion de datos a enviar al modelo--
        if (validar::correo($login->correo) && validar::password($login->password)) {
            $login->validatedUser();
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }

    public function logout(): void
    {
        // --Validacion de cerrar sesion--
        if (SesionTools::cerrarsesion()) {
            echo json_encode(array('status' => '1', 'data' => NULL));
        } else {
            echo json_encode(array('status' => '2', 'data' => NULL));
        }
    }

    public static function verificar($submoduloPermitido)
    {
        $arrayPermisos = SesionTools::getParametro('permisos');
        $token = SesionTools::getParametro('token');
        if ($arrayPermisos != null && $token == "dqtQS2cBmGd8MbyMCHBj3Dq38Xm89vVyxxum4aySt9witAwBN9") {
            for ($i = 0; $i < count($arrayPermisos); $i++) {
                if (count($arrayPermisos[$i]["submodulos"]) > 0) {
                    for ($j = 0; $j < count($arrayPermisos[$i]["submodulos"]); $j++) {
                        $submodulo = $arrayPermisos[$i]["submodulos"][$j];
                        $arraySubmodulo = explode('|JUAN|', $submodulo);
                        $submoduloVerificar = $arraySubmodulo[2];
                        if ($submoduloVerificar == $submoduloPermitido) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    public static function verificarUsuario()
    {
        $arrayPermisos = SesionTools::getParametro('permisos');
        $token = SesionTools::getParametro('token');
        if ($arrayPermisos != null && $token == "dqtQS2cBmGd8MbyMCHBj3Dq38Xm89vVyxxum4aySt9witAwBN9") {
            if (count($arrayPermisos) > 0) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public static function menuDinamico()
    {
        $arrayPermisos = SesionTools::getparametro('permisos');
        $token = SesionTools::getparametro('token');
        $html = "";

        if ($token == "dqtQS2cBmGd8MbyMCHBj3Dq38Xm89vVyxxum4aySt9witAwBN9") {
            for ($i = 0; $i < count($arrayPermisos); $i++) {
                $html .= '<div class="nav-item has-sub text-capitalize"><a class="cursor-pointer"><i class="' . $arrayPermisos[$i]["icono"] . '"></i><span>' . $arrayPermisos[$i]["modulo"] . '</span></a>';

                for ($j = 0; $j < count($arrayPermisos[$i]["submodulos"]); $j++) {
                    $submodulo = $arrayPermisos[$i]["submodulos"][$j];
                    $arraySubmodulo = explode('|JUAN|', $submodulo);
                    $html .= '<div class="submenu-content"><a href="' . $arraySubmodulo[1] . '" class="menu-item"><i class="ik ik-corner-down-right nav-icon"></i>' . $arraySubmodulo[0] . '</a></div>';
                }

                $html .= '</div>';
            }
        }

        return $html;
    }
}
