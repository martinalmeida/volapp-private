<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/volapp/inc/volappConfig.php');
include_once($_SERVER['DOCUMENT_ROOT'] . INCLUDES . 'template.php');
Template::Head('404');
Template::startBody();
?>

<!-- ========== Inicio Componente de Vista ========== -->
<div class="subheader">
    <h1 class="subheader-title">
        <i class='fal fa-info-circle'></i> INICIO
        <small>
            SUB TITULO
        </small>
    </h1>
</div>
<div class="fs-lg fw-300 p-5 bg-white border-faded rounded mb-g">
    <h3 class="mb-g">
        DIV VACIO
    </h3>
    <p>
        DIV VACIO.
    </p>
</div>
<h3>
    Titulo abajo
</h3>
<!-- ========== Fin Componente de Vista ========== -->

<?= Template::endBody(); ?>