<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/volapp/inc/volappConfig.php');
include_once(VIEW_CONTROLLER);

use View\ViewController;

$view = new ViewController('maquinarias');

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
                    Tabla de Maquinarias
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
                    <table id="tablaMaquinarias" class="table table-bordered table-hover table-striped w-100">
                        <thead class="bg-primary-600">
                            <tr>
                                <th>id</th>
                                <th>Equipo o clase</th>
                                <th>Placa</th>
                                <th>Marca</th>
                                <th>Referencia</th>
                                <th>Modelo</th>
                                <th>Color</th>
                                <th>Capacidad</th>
                                <th>Nro de Serie</th>
                                <th>Nro Serie de Chasis</th>
                                <th>Nro de Motor</th>
                                <th>Rodaje</th>
                                <th>Rut</th>
                                <th>GPS</th>
                                <th>Vencimiento del SOAT</th>
                                <th>Vencimiento de Tecnocomecánica</th>
                                <th>Nombre del Propietario</th>
                                <th>Documento del Propietario</th>
                                <th>Telefono del Propietario</th>
                                <th>Correo del Propietario</th>
                                <th>Nombre del Operador</th>
                                <th>Documento del Operador</th>
                                <th>Telefono del Operador</th>
                                <th>Correo del Operador</th>
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
    Pagina de Vehiculos
</h3>

<?php
include_once(VIEW . 'maquinarias/modalForm.php');
$view->finalizeView();
