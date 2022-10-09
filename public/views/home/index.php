<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/volapp/inc/volappConfig.php');
include_once($_SERVER['DOCUMENT_ROOT'] . INCLUDES . 'template.php');
Template::verificarSesion();
Template::Head('Home');
Template::startBody();
?>

<!-- ========== Inicio Componente de Vista ========== -->
<div class="subheader">
    <h1 class="subheader-title">
        <i class='fal fa-info-circle'></i> Home
    </h1>
</div>

<div class="row">
    <div class="col-lg-6 col-xl-9 order-lg-1 order-xl-1">
        <!-- profile summary -->
        <div class="card mb-g rounded-top">
            <div class="row no-gutters row-grid">
                <div class="col-12">
                    <div class="d-flex flex-column align-items-center justify-content-center p-4">
                        <img src="img/demo/avatars/avatar-admin-lg.png" class="rounded-circle shadow-2 img-thumbnail" alt="">
                        <h5 class="mb-0 fw-700 text-center mt-3">
                            Dr. Codex Lantern
                            <small class="text-muted mb-0">Toronto, Canada</small>
                        </h5>
                        <div class="mt-4 text-center demo">
                            <a href="javascript:void(0);" class="fs-xl" style="color:#3b5998">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="javascript:void(0);" class="fs-xl" style="color:#38A1F3">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="javascript:void(0);" class="fs-xl" style="color:#db3236">
                                <i class="fab fa-google-plus"></i>
                            </a>
                            <a href="javascript:void(0);" class="fs-xl" style="color:#0077B5">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="javascript:void(0);" class="fs-xl" style="color:#000000">
                                <i class="fab fa-reddit-alien"></i>
                            </a>
                            <a href="javascript:void(0);" class="fs-xl" style="color:#00AFF0">
                                <i class="fab fa-skype"></i>
                            </a>
                            <a href="javascript:void(0);" class="fs-xl" style="color:#0063DC">
                                <i class="fab fa-flickr"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-center py-3">
                        <h5 class="mb-0 fw-700">
                            764
                            <small class="text-muted mb-0">Connections</small>
                        </h5>
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-center py-3">
                        <h5 class="mb-0 fw-700">
                            1,673
                            <small class="text-muted mb-0">Followers</small>
                        </h5>
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-3 text-center">
                        <a href="javascript:void(0);" class="btn-link font-weight-bold">Follow</a> <span class="text-primary d-inline-block mx-3">&#9679;</span>
                        <a href="javascript:void(0);" class="btn-link font-weight-bold">Message</a> <span class="text-primary d-inline-block mx-3">&#9679;</span>
                        <a href="javascript:void(0);" class="btn-link font-weight-bold">Connect</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-lg-6 col-xl-3 order-lg-2 order-xl-3">
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

<?= Template::endBody(); ?>