<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/volapp/inc/volappConfig.php');
include_once(VIEW_CONTROLLER);

use View\ViewController;

$view = new ViewController('relacionFletes');

$view->initializationView();
?>

<!-- ========== Inicio Componente de Vista ========== -->
<div class="subheader" id="permisoSuperior">

</div>

<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Generar Relación de Fletes:
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content" id="relacionRender">
                </div>
                <div class="panel-content" id="relacionGenerada">
                </div>
            </div>
        </div>
    </div>
</div>

<h3>
    Pagina de Informe de Relación
</h3>

<?= $view->finalizeView();
