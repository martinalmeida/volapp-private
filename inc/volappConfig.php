<?php
// Definir el uso horario o timezone del sistema
date_default_timezone_set('America/Bogota');

// Lenguaje
define('LANG', 'es');

// Rutas principales
define('ROOT_PATH', '/volapp/');
define('APP', ROOT_PATH . 'app/');
define('RESOURCES', ROOT_PATH . 'resources/');
define('ASEETS', ROOT_PATH . 'aseets/');
define('INC', ROOT_PATH . 'inc/');
define('PUBLIC_PATH', ROOT_PATH . 'public/');

// Rutas de la app
define('CONTROLLERS', APP . 'controllers/');
define('INCLUDES', APP . 'includes/');
define('LIBRARIES', APP . 'librariEs/');
define('MODELS', APP . 'models/');
define('ROOTS', APP . 'roots/rootController.php');

// Rutas de interfaz
define('JSAJAX', PUBLIC_PATH . 'js/');
define('VIEW', PUBLIC_PATH . 'views/');

// Rutas de estilos
define('ASSETS', RESOURCES . 'assets/');
define('CSS', ASSETS . 'css/');
define('IMG', ASSETS . 'img/');
define('FONTS', ASSETS . 'webfonts/');

// Rutas de javaScript y componentes
define('COMPONENTS', RESOURCES . 'components/');
define('JS', RESOURCES . 'js/');

// Composer Autoload.php
define('COMPOSER', ROOT_PATH . 'vendor/autoload.php');

// Login
define('LOGIN', VIEW . 'login/');
