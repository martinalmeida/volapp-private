<?php

declare(strict_types=1);

include_once(LIBRARIES . 'sesion.php');

class SesionController
{
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
        $arrayPermisos[] = SesionTools::getparametro('permisos');
        $token = SesionTools::getparametro('token');

        $html = "";

        if ($token == "dqtQS2cBmGd8MbyMCHBj3Dq38Xm89vVyxxum4aySt9witAwBN9") {
            echo gettype($arrayPermisos[0]);
            // foreach ($arrayPermisos[0] as $key => $value) {
            //     echo $key . ':' . $value . '<br>';
            // }
        }
        return $html;

        // var_dump($_SESSION['permisos']);

        // $html = "";

        // if ($token == "dqtQS2cBmGd8MbyMCHBj3Dq38Xm89vVyxxum4aySt9witAwBN9") {
        //     for ($i = 0; $i < count($arrayPermisos); $i++) {
        //         $html .= '<div class="nav-item has-sub text-capitalize"><a class="cursor-pointer"><i class="' . $arrayPermisos[$i]["icono"] . '"></i><span>' . $arrayPermisos[$i]["modulo"] . '</span></a>';

        //         for ($j = 0; $j < count($arrayPermisos[$i]["submodulos"]); $j++) {
        //             $submodulo = $arrayPermisos[$i]["submodulos"][$j];
        //             $arraySubmodulo = explode('|JUAN|', $submodulo);
        //             $html .= '<div class="submenu-content"><a href="' . $arraySubmodulo[1] . '" class="menu-item"><i class="ik ik-corner-down-right nav-icon"></i>' . $arraySubmodulo[0] . '</a></div>';
        //         }

        //         $html .= '</div>';
        //     }
        // }

        // return $html;
    }
}
