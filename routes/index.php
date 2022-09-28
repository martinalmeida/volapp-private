<?php
require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/routing.php');

$router = new Roting;
$router->run();
