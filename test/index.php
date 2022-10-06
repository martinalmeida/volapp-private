<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/volapp/inc/volappConfig.php');
include_once($_SERVER['DOCUMENT_ROOT'] . INCLUDES . 'template.php');
Template::Head('Test Rutas');
Template::startBody();
?>

<!-- ========== Inicio Componente de Vista ========== -->
<div class="subheader">
    <h1 class="subheader-title">
        Tets de Rutas
    </h1>
</div>
<div class="fs-lg fw-300 p-5 bg-white border-faded rounded mb-g">
    <h3 class="mb-g">
        <form id="frmTest">
            <div class="form-row">
                <div class="col-md-10 mb-3">
                    <input type="text" class="form-control" id="testRutes" name="testRutes" placeholder="Introducir ruta a probar">
                </div>
                <div class="col-md-2 mb-3">
                    <select class="form-control" name="methodAjax" id="methodAjax">
                        <option value="POST">Method POST</option>
                        <option value="GET">Method GET</option>
                    </select>
                </div>
            </div>
            <a class="btn btn-primary text-white" id="btnLoginIngresar" onclick="testRoute('frmTest');">Testear Ruta</a>
        </form>
    </h3>
    <div id="resultadoRuta">

    </div>
</div>

<!-- ========== Fin Componente de Vista ========== -->

<?= Template::endBody(); ?>
<?= Template::azyncScript('test'); ?>