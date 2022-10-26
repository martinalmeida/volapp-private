<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/volapp/inc/volappConfig.php');
include_once(VIEW_CONTROLLER);

use View\ViewController;

$view = new ViewController('empresas');

$view->initializationView();
?>

<!-- ========== Inicio Componente de Vista ========== -->
<div class="subheader">
    <h1 class="subheader-title">
        <i class='fal fa-info-circle'></i> Empresas
    </h1>
    <button type="button" class="btn btn-info active" onclick="showModalRegistro();">Agregar <i class="fa-solid fa-plus"></i></button>
</div>

<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Tabla de Empresas
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
                    <table id="tablaEmpresas" class="table table-bordered table-hover table-striped w-100">
                        <thead class="bg-primary-600">
                            <tr>
                                <th>Nit</th>
                                <th>Digito</th>
                                <th>Nombre</th>
                                <th>Representante</th>
                                <th>Telefono</th>
                                <th>Direccion</th>
                                <th>Correo Electronico</th>
                                <th>Pais</th>
                                <th>Ciudad</th>
                                <th>Nmro. Contacto</th>
                                <th>Correo Tecnico</th>
                                <th>Correo Logistica</th>
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
    Pagina de Empresas
</h3>

<?php
include_once(VIEW . 'empresas/modalForm.php');
$view->finalizeView();
