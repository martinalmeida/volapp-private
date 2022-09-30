<?php
class Roting
{
    private $controller;
    private $method;

    public function __construct()
    {
        if (URL !== '/') {
            $this->matchRoute();
        }
    }

    public function matchRoute()
    {
        $url = explode('/', URL);
        $this->controller = $url[1];
        $this->method = $url[2];
        $this->controller = $this->controller . 'controller';
        require_once($_SERVER['DOCUMENT_ROOT'] . '/vlapp/app/controllers/' . $this->controller . '.php');
    }

    public function run()
    {
        $controller = new $this->controller();
        $method = $this->method;
        $controller->$method();
    }
}
