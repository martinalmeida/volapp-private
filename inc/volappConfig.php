<?php
// Definir el uso horario o timezone del sistema
date_default_timezone_set('America/Bogota');

// Lenguaje
define('LANG', 'es');

// Ruta del servidor
define('SERVER', $_SERVER['DOCUMENT_ROOT'] . '/volapp/');

// Rutas principales
define('ROOT_PATH', '/volapp/');
define('APP', SERVER . 'app/');
define('RESOURCES', ROOT_PATH . 'resources/');
define('ASEETS', ROOT_PATH . 'aseets/');
define('INC', SERVER . 'inc/');
define('PUBLIC_PATH', ROOT_PATH . 'public/');
define('PUBLIC_PATH_SERVER', SERVER . 'public/');

// Rutas de la app
define('CONTROLLERS', APP . 'controllers/');
define('INCLUDES', APP . 'includes/');
define('LIBRARIES', APP . 'libraries/');
define('MODELS', APP . 'models/');
define('ROOTS', APP . 'roots/rootController.php');

// Rutas de interfaz
define('JSAJAX', PUBLIC_PATH . 'js/');
define('VIEW_HREF', PUBLIC_PATH . 'views/');
define('VIEW', PUBLIC_PATH_SERVER . 'views/');

// Rutas de estilos
define('ASSETS', RESOURCES . 'assets/');
define('CSS', ASSETS . 'css/');
define('IMG', ASSETS . 'img/');
define('FONTS', ASSETS . 'webfonts/');

// Rutas de javaScript y componentes
define('COMPONENTS', RESOURCES . 'components/');
define('JS', RESOURCES . 'js/');

// Rutas a archivos puntuales
define('DB', INC . '/db.php');
define('COMPOSER', SERVER . 'vendor/autoload.php');
define('TEMPLATE', INCLUDES . '/template.php');
define('TEMPLATE_LOGIN', INCLUDES . '/templateLogin.php');
define('VIEW_CONTROLLER', CONTROLLERS . '/viewController.php');

// Login vista
define('LOGIN', VIEW . 'login/');
