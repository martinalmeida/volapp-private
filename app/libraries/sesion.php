<?php

declare(strict_types=1);

ini_set("session.cookie_lifetime", "600000");
ini_set("session.gc_maxlifetime", "600000");
session_start();
session_regenerate_id();

class SesionTools
{
    public static function setParametro($parametro, $valor)
    {
        $_SESSION[$parametro] = $valor;
    }

    public static function crearSesion($parametros)
    {
        // self::iniciarTiempoSesion();
        foreach ($parametros as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }

    public static function iniciarTiempoSesion()
    {
        // 900 segundos - 15 minutos
        // 600000 segundos - 10.000 minuntos
        ini_set("session.cookie_lifetime", "600000");
        ini_set("session.gc_maxlifetime", "600000");
        session_start();
        session_regenerate_id();
    }

    public static function getParametro($parametro)
    {

        if (isset($_SESSION[$parametro])) {
            return $_SESSION[$parametro];
        } else {
            return false;
        }
    }

    public static function cerrarSesion()
    {
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        $_SESSION = array();
        session_destroy();
        return true;
    }
}
