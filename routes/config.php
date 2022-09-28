<?php
require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/routing.php');

$folderPath =  dirname($_SERVER['SCRIPT_NAME']);
$urlPath =  $_SERVER['REQUEST_URI'];
$url =  substr($urlPath, strlen($folderPath));

define('URL', $url);
