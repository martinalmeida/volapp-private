<?php

declare(strict_types=1);

namespace App;

class InitRouting
{
    private const TOKEN = 'dqtQS2cBmGd8MbyMCHBj3Dq38Xm89vVyxxum4aySt9witAwBN9';
    private $tokenUser;

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

    public function startRouting()
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $this->tokenUser = $_POST["token"];
            if (self::TOKEN === $this->tokenUser) {
                if (URL !== '/') {
                    require_once(__DIR__ . '/routing.php');
                    $router = new Routing;
                    $router->run();
                } else {
                    $request['status'] = '0';
                    echo json_encode($request);
                }
            } else {
                echo json_encode('NO HAY TOKEN QUE COINCIDA');
                $this->tokenUser = NULL;
                exit;
            }
        } else {
            echo json_encode('SERVICIOS DENEGADOS POR NO CUMPLIR CON LAS REGLAS');
            $this->tokenUser = NULL;
            exit;
        }
    }
}
