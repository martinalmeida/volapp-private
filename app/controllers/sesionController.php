<?php

declare(strict_types=1);

include_once(MODELS . 'modelSesion.php');

class SesionController
{
    private const TOKEN = 'dqtQS2cBmGd8MbyMCHBj3Dq38Xm89vVyxxum4aySt9witAwBN9';

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

    public static function menuDinamico(): void
    {
        $token = SesionTools::getparametro('token');

        if ($token == self::TOKEN) {

            // --Importacion e inicializacion de conexion--
            include_once(DB);
            $database = new Database();
            $db = $database->getConnection();
            $menu = new Sesion($db);

            $html = $menu->getMenuDinamico();
            echo $html;
        }
    }
}
