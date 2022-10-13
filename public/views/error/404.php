<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/volapp/inc/volappConfig.php');
include_once(VIEW_CONTROLLER);

use View\ViewController;

$view = new ViewController('404');

$view->initializationView();
?>

<!-- ========== Inicio Componente de Vista ========== -->
<div class="h-alt-hf d-flex flex-column align-items-center justify-content-center text-center" id="workSpace">
</div>
<!-- ========== Fin Componente de Vista ========== -->

<?= $view->finalizeView();
