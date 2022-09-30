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
define('LIBRARIES', APP . 'librarias/');
define('MODELS', APP . 'models/');

// Rutas de interfaz
define('JSFETCH', PUBLIC_PATH . 'js/');
define('VIEW', PUBLIC_PATH . 'views/');

// Rutas de estilos
define('ASSETS', RESOURCES . 'assets/');
define('CSS', ASSETS . 'css/');
define('IMG', ASSETS . 'img/');
define('FONTS', ASSETS . 'webfonts/');

// Rutas de javaScript y componentes
define('COMPONENTS', RESOURCES . 'components/');
define('JS', RESOURCES . 'js/');

// Credenciales de la base de datos
define('HOST_DB', 'localhost');
define('USER_DB', 'root');
define('PASSWORD_DB', '');
define('NAME_DB', 'irma');
define('LDB_CHARSET', 'utf8');
