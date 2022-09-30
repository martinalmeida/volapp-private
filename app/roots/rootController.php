<?php
class Roots
{
    private $folder;
    private $file;

    // --Ruta principal--
    public static function vlapp($folder, $file)
    {
        $self = new self();
        $self->folder = $folder;
        $self->file = $file;
        $url = '/volapp/public/views/' . $self->folder . '/' . $self->file;
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $url . '.php')) {
            header('Location: ' . $url);
        } else {
            self::error404('error', '404');
        }
    }

    // --Error de pagina no encontrada--
    public static function error404($folder, $file)
    {
        $self = new self();
        $self->folder = $folder;
        $self->file = $file;
        $url = '/volapp/public/views/' . $self->folder . '/' . $self->file;
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $url . '.php')) {
            header('Location: ' . $url);
        } else {
            echo 'error no existe esta ruta';
        }
    }
}
