<?php

declare(strict_types=1);

namespace View;

use Template;
use TemplateLogin;

include_once(TEMPLATE);
include_once(TEMPLATE_LOGIN);

class ViewController
{
    private const LOGIN = 'login';
    private $modulo;

    public function __construct($modulo)
    {
        $this->modulo = $modulo;
    }

    public function initializationView(): void
    {
        if ($this->modulo == self::LOGIN) {
            echo TemplateLogin::head($this->modulo);
            echo TemplateLogin::startBody();
        } else {
            echo Template::verificarSesion();
            echo Template::head($this->modulo);
            echo Template::startBody();
        }
    }

    public function finalizeView(): void
    {
        if ($this->modulo == self::LOGIN) {
            echo TemplateLogin::endBody('frmLogin', 'btnLoginIngresar');
            echo TemplateLogin::azyncScript($this->modulo);
        } else {
            echo Template::endBody();
            echo Template::azyncScript($this->modulo);
        }
    }
}
