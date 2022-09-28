<?php
// Definir el uso horario o timezone del sistema
date_default_timezone_set('America/Bogota');

// Lenguaje
define('LANG', 'es');

// Rutas principales
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/vlapp/');
define('INC', ROOT_PATH . 'inc/');
define('APP', ROOT_PATH . 'app/');

// Rutas de la app
define('CONTROLLERS', APP . 'controllers/');
define('INCLUDES', APP . 'includes/');
define('LIBRARIES', APP . 'librarias/');
define('MODELS', APP . 'models/');

// // Rutas de archivos o assets con base URL
// define('ASSETS', URL . 'assets/');
// define('CSS', ASSETS . 'css/');
// define('FAVICON', ASSETS . 'favicon/');
// define('FONTS', ASSETS . 'fonts/');
// define('IMAGES', ASSETS . 'images/');
// define('JS', ASSETS . 'js/');
// define('PLUGINS', ASSETS . 'plugins/');
// define('UPLOADS', ASSETS . 'uploads/');

// Credenciales de la base de datos
define('HOST_DB', 'localhost');
define('USER_DB', 'root');
define('PASSWORD_DB', '');
define('NAME_DB', 'irma');
define('LDB_CHARSET', 'utf8');
