<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/volapp/inc/volappConfig.php');
include_once(VIEW_CONTROLLER);

use View\ViewController;

$view = new ViewController('informes');

$view->initializationView();
?>

<!-- ========== Inicio Componente de Vista ========== -->
<div class="subheader">
    <h1 class="subheader-title">
        <i class="fal fa-info-circle"></i> Informe de Relación por Alquiler
    </h1>
</div>

<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2></h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <form id="frmRegistro">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Placa o # de Registro:</label>
                                <select class="custom-select form-control" id="placaInsert" name="placaInsert">
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Asignar Contrato:</label>
                                <select class="custom-select form-control" id="contratoInsert" name="contratoInsert">
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<h3>
    Pagina de Informe de Relación
</h3>

<?= $view->finalizeView();
