<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/volapp/inc/volappConfig.php');
include_once(VIEW_CONTROLLER);

use View\ViewController;

$view = new ViewController('usuarios');

$view->initializationView();
?>

<!-- ========== Inicio Componente de Vista ========== -->
<div class="subheader">
    <h1 class="subheader-title">
        <i class='fal fa-info-circle'></i> Usuarios
    </h1>
    <button type="button" class="btn btn-info active" data-toggle="modal" data-target="#default-example-modal-lg">Agregar <i class="fa-solid fa-plus"></i></button>
</div>

<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Tabla de Usuarios
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
                    <table id="tablaUsuarios" class="table table-bordered table-hover table-striped w-100">
                        <thead class="bg-primary-600">
                            <tr>
                                <th>Id</th>
                                <th>Identificación</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Telefono</th>
                                <th>Correo</th>
                                <th>RUC</th>
                                <th>Nombre del Fiscal</th>
                                <th>Dirección Fiscal</th>
                                <th>Rol</th>
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
    Pagina de Usuarios
</h3>

<?php
include_once(VIEW . 'usuarios/modalForm.php');
$view->finalizeView();
