<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/volapp/inc/volappConfig.php');
include_once(VIEW_CONTROLLER);

use View\ViewController;

$view = new ViewController('home');

$view->initializationView();
?>

<!-- ========== Inicio Componente de Vista ========== -->
<div class="subheader">
    <h1 class="subheader-title">
        <i class='fal fa-info-circle'></i> Inicio
    </h1>
</div>

<div class="row">
    <div class="col-lg-9 col-xl-9 order-lg-1 order-xl-1" id="workSpace">
    </div>

    <div class="col-lg-3 col-xl-3 order-lg-2 order-xl-3">
        <!-- add : -->
        <div class="card mb-2">
            <div class="card-body">
                <a href="javascript:void(0);" class="d-flex flex-row align-items-center">
                    <div class='icon-stack display-3 flex-shrink-0'>
                        <i class="fal fa-circle icon-stack-3x opacity-100 color-primary-400"></i>
                        <i class="fas fa-graduation-cap icon-stack-1x opacity-100 color-primary-500"></i>
                    </div>
                    <div class="ml-3">
                        <strong>
                            Add Qualifications
                        </strong>
                        <br>
                        Adding qualifications will help gain more clients
                    </div>
                </a>
            </div>
        </div>
        <div class="card mb-g">
            <div class="card-body">
                <a href="javascript:void(0);" class="d-flex flex-row align-items-center">
                    <div class='icon-stack display-3 flex-shrink-0'>
                        <i class="fal fa-circle icon-stack-3x opacity-100 color-warning-400"></i>
                        <i class="fas fa-handshake icon-stack-1x opacity-100 color-warning-500"></i>
                    </div>
                    <div class="ml-3">
                        <strong>
                            Add Skills
                        </strong>
                        <br>
                        Gain more potential clients by adding skills
                    </div>
                </a>
            </div>
        </div>

    </div>
</div>

<h3>
    Pagina de inicio
</h3>
<!-- ========== Fin Componente de Vista ========== -->

<?= $view->finalizeView();
