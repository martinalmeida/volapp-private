<?php

declare(strict_types=1);

include_once(MODELS . 'modelSesion.php');

class SesionController
{
    private const TOKEN = 'dqtQS2cBmGd8MbyMCHBj3Dq38Xm89vVyxxum4aySt9witAwBN9';

    public static function verificarUsuario()
    {

        $token = SesionTools::getParametro('token');
        $nit = SesionTools::getParametro('nit');
        $user = SesionTools::getParametro('id');
        if ($token == self::TOKEN && $nit != 0 && $user != 0) {
            return true;
        } else {
            return false;
        }
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
