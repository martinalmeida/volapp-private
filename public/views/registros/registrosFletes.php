<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/volapp/inc/volappConfig.php');
include_once(VIEW_CONTROLLER);

use View\ViewController;

$view = new ViewController('registrosFletes');

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
                    Tabla de Registros de Fletes
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
                    <table id="tablaRegistrosFletes" class="table table-bordered table-hover table-striped w-100">
                        <thead class="bg-primary-600">
                            <tr>
                                <th>id</th>
                                <th>Cod. Ficha</th>
                                <th>Placa o Nro Registro</th>
                                <th>Acuerdo de Flete o Ruta</th>
                                <th>Valor Flete</th>
                                <th>Fecha de Inicio</th>
                                <th>Fecha Final</th>
                                <th>Titulo del Contrato</th>
                                <th>Observación</th>
                                <th>Usuarios</th>
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
    Pagina de Registros de Fletes
</h3>

<?php
include_once(VIEW . 'registros/modalRegistrosFletes.php');
$view->finalizeView();
