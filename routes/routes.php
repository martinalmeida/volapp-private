<?php
require_once __DIR__ . "/vendor/autoload.php";

// --Traemos los paquetes--
use EasyProjects\SimpleRouter\Router as Router;
use EasyProjects\SimpleRouter\Request as Request;
use EasyProjects\SimpleRouter\Response as Response;

// --Iniciamos nuestra clase Router--
$router = new Router;

// --Habilitamos CORS para FetchApi--
$router->cors(
    "http://localhost/vlapp/",
    "*",
    "*"
);

// --Requerimos a todos los archivos--
$router->importAll("../app/home");

$router->get("/get/{idUser}", function (Request $req, Response $res) {
    $res->status(200)->send($req->params->idUser);
});

$router->post("/add", function (Request $req, Response $res) {
    //Get Files
    $res->status(200)->send($req->body->nameUser);
});

$router->put("/update/{idUser}", function (Request $req, Response $res) {
    $res->status(200)->send($req->params->idUser . " - " . $req->body->nameUser);
});

$router->delete("/delete/{idUser}", function (Request $req, Response $res) {
    $res->status(200)->send($req->params->idUser . " - " . $req->body->nameUser);
});

// --Cargamos todos los metodos--
$router->start();
