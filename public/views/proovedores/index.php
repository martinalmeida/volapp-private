<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/volapp/inc/volappConfig.php');
include_once(VIEW_CONTROLLER);

use View\ViewController;

$view = new ViewController('proovedores');

$view->initializationView();
?>

<!-- ========== Inicio Componente de Vista ========== -->
<div class="subheader">
    <h1 class="subheader-title">
        <i class="fal fa-info-circle"></i> Relación de Proovedor
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
                    <div class="panel-content">
                        <div class="card-group">
                            <div class="card bg-success">
                                <div class="card-body text-center">
                                    <h3 class="card-title text-white">Relación por Alquiler</h3>
                                    <h1 class="text-white"><i class="fal fa-hands-usd fa-4x"></i></i></h1>
                                    <p class="card-text text-white">En el modo alquiler se calcula el Stand By de horas, u horometro final menos horometro inicial.</p>
                                    <button type="button" class="btn btn-outline-light btn-pills waves-effect waves-themed" onclick="getRuta(1);">Ingresar al Informe de Relación por Alquiler</button>
                                </div>
                            </div>
                            <div class="card bg-info">
                                <div class="card-body text-center">
                                    <h3 class="card-title text-white">Relación por Flete</h3>
                                    <h1 class="text-white"><i class="fal fa-route fa-4x"></i></h1>
                                    <p class="card-text text-white">En el modo flete se calcula solo un valor pactado por viaje con el socio o dueño del vehículo.</p>
                                    <button type="button" class="btn btn-outline-light btn-pills waves-effect waves-themed" onclick="getRuta(2);">Ingresar al Informe de Relación por Fletes</button>
                                </div>
                            </div>
                            <div class="card bg-primary">
                                <div class="card-body text-center">
                                    <h3 class="card-title text-white">Relación por Movimiento</h3>
                                    <h1 class="text-white"><i class="fal fa-truck-container fa-4x"></i></h1>
                                    <p class="card-text text-white">Calculo de nro de viajes, tarifa de ruta pactada, metraje cubico y kilometros recorridos.</p>
                                    <button type="button" class="btn btn-outline-light btn-pills waves-effect waves-themed" onclick="getRuta(3);">Ingresar al Informe de Relación por Movimientos</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<h3>
    Pagina de Relación de Proovedor
</h3>

<?= $view->finalizeView();
