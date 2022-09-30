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
        $fileController = $_SERVER['DOCUMENT_ROOT'] . '/volapp/app/controllers/' . $this->controller . '.php';
        if (file_exists($fileController)) {
            require_once($fileController);
        } else {
            $request['status'] = '4';
            echo json_encode($request);
        }
    }

    public function run()
    {
        $controller = new $this->controller();
        $method = $this->method;
        $controller->$method();
    }
}
