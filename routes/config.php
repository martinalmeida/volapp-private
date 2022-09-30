<?php
error_reporting(0);
require_once(__DIR__ . '/routing.php');
class Api
{
    public function __construct()
    {
        $this->config();
    }

    public function config()
    {
        $folderPath =  dirname($_SERVER['SCRIPT_NAME']);
        $urlPath =  $_SERVER['REQUEST_URI'];
        $url =  substr($urlPath, strlen($folderPath));
        define('URL', $url);
    }

    public function startApi()
    {
        if (URL !== '/') {
            $router = new Roting;
            $router->run();
        } else {
            $request['status'] = '0';
            echo json_encode($request);
        }
    }
}
