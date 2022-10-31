<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/volapp/inc/volappConfig.php');
include_once(VIEW_CONTROLLER);

use View\ViewController;

$view = new ViewController('rutas');

$view->initializationView();
?>

<!-- ========== Inicio Componente de Vista ========== -->
<div class="subheader">
    <h1 class="subheader-title">
        <i class='fal fa-info-circle'></i> Rutas
    </h1>
    <button type="button" class="btn btn-info active" onclick="showModalRegistro();">Agregar <i class="fal fa-plus-square"></i></button>
</div>

<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Tabla de Placas
                    <!-- Tabla <span class="fw-300"><i>Usuarios</i></span> -->
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <!-- <div class="panel-tag">
                    </div> -->
                    <table id="tablaPlacas" class="table table-bordered table-hover table-striped w-100">
                        <thead class="bg-primary-600">
                            <tr>
                                <th>id</th>
                                <th>Placa</th>
                                <th>Nombres del Conductor</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Telefono</th>
                                <th>Correo Electronico</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!-- datatable end -->
                </div>
            </div>
        </div>
    </div>
</div>

<h3>
    Pagina de Placas
</h3>

<?php
include_once(VIEW . 'placas/modalForm.php');
$view->finalizeView();
