<?php

declare(strict_types=1);

namespace App;

header('Content-type: application/json');

class InitRouting
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

    public function startRouting(): void
    {
        // --Validamos si es una peticion HTTPS--
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            // --Comprobar si hay un metodo autorizado GET && POST
            if ($_SERVER['REQUEST_METHOD'] == 'GET' or $_SERVER['REQUEST_METHOD'] == 'POST') {
                // --Validacion de ruta
                if (URL !== '/') {
                    // --Ejecucion del router
                    require_once(__DIR__ . '/routing.php');
                    $router = new Routing;
                    $router->run();
                } else {
                    echo json_encode(array('status' => '8', 'data' => NULL));
                }
            } else {
                echo json_encode(array('status' => '9', 'data' => NULL));
                exit;
            }
        } else {
            echo json_encode(array('status' => '10', 'data' => NULL));
            exit;
        }
    }
}
