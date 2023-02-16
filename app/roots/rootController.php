<?php

declare(strict_types=1);

include_once($_SERVER['DOCUMENT_ROOT'] . '/inc/volappConfig.php');
include_once(CONTROLLERS . 'sesionController.php');

class Roots
{
    private $folder;
    private $file;

    // --Ruta principal--
    public static function volapp($folder)
    {
        $self = new self();
        $self->folder = $folder;
        $url = '/public/views/' . $self->folder;
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $url . '/index.php')) {
            header('Location: ' . $url);
        } else {
            self::error404('error', '404');
        }
    }

    // --Ruta Inicio de Sesion HOME--
    public static function inicioSesion()
    {
        $verificar = SesionController::verificarUsuario();
        if ($verificar === TRUE) {
            return HOME;
        } else {
            return LOGIN;
        }
    }

    // --Rutas de Registros--
    public static function regitrosRoots($numero)
    {
        $verificar = SesionController::verificarUsuario();
        if ($verificar === TRUE) {
            switch ($numero) {
                case '1':
                    return REGISTROSALQUILER;
                    break;

                case '2':
                    return REGISTROSFLETES;
                    break;

                case '3':
                    return REGISTROSMOVIMIENTOS;
                    break;

                default:
                    # code...
                    break;
            }
        } else {
            return LOGIN;
        }
    }

    // --Rutas de Informes--
    public static function informesRoots($numero)
    {
        $verificar = SesionController::verificarUsuario();
        if ($verificar === TRUE) {
            switch ($numero) {
                case '1':
                    return INFORMESALQUILER;
                    break;

                case '2':
                    return INFORMESFLETES;
                    break;

                case '3':
                    return INFORMESMOVIMIENTOS;
                    break;

                default:
                    # code...
                    break;
            }
        } else {
            return LOGIN;
        }
    }

    // --Rutas de proovedores--
    public static function proovedoresRoots($numero)
    {
        $verificar = SesionController::verificarUsuario();
        if ($verificar === TRUE) {
            switch ($numero) {
                case '1':
                    return PROOVEDORALQUILER;
                    break;

                case '2':
                    return PROOVEDORFLETES;
                    break;

                case '3':
                    return PROOVEDORMOVIMIENTOS;
                    break;

                default:
                    # code...
                    break;
            }
        } else {
            return LOGIN;
        }
    }

    // --Error de pagina no encontrada--
    public static function error404($folder, $file)
    {
        $self = new self();
        $self->folder = $folder;
        $self->file = $file;
        $url = '/public/views/' . $self->folder . '/' . $self->file;
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $url . '.php')) {
            header('Location: ' . $url);
        } else {
            echo 'error no existe esta ruta';
        }
    }
}
