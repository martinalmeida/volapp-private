<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/volapp/inc/volappConfig.php');
include_once($_SERVER['DOCUMENT_ROOT'] . INCLUDES . 'template.php');
Template::headLogin('Login');
Template::startBodyLogin();
?>

<div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
    <div class="row">
        <div class="col col-md-6 col-lg-7 hidden-sm-down">
            <h2 class="fs-xxl fw-500 mt-4 text-white">
                VACIO &amp; VACIO
                <small class="h3 fw-300 mt-3 mb-5 text-white opacity-60">
                    EJEMPLO
                </small>
            </h2>
            <a href="#" class="fs-lg fw-500 text-white opacity-70">Ver más &gt;&gt;</a>
            <div class="d-sm-flex flex-column align-items-center justify-content-center d-md-block">
                <div class="px-0 py-1 mt-5 text-white fs-nano opacity-50">
                    REDES SOCIALES
                </div>
                <div class="d-flex flex-row opacity-70">
                    <a href="#" class="mr-2 fs-xxl text-white">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                    <a href="#" class="mr-2 fs-xxl text-white">
                        <i class="fab fa-twitter-square"></i>
                    </a>
                    <a href="#" class="mr-2 fs-xxl text-white">
                        <i class="fab fa-google-plus-square"></i>
                    </a>
                    <a href="#" class="mr-2 fs-xxl text-white">
                        <i class="fab fa-linkedin"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-5 col-xl-4 ml-auto">
            <h1 class="text-white fw-300 mb-3 d-sm-block d-md-none">
              Inicio de sesión seguro
            </h1>
            <div class="card p-4 rounded-plus bg-faded">
                <form id="js-login" novalidate="" action="intel_analytics_dashboard.html">
                    <div class="form-group">
                        <label class="form-label" for="username">Usuario</label>
                        <input type="email" id="username" class="form-control form-control-lg" placeholder="your id or email" value="drlantern@gotbootstrap.com" required>
                        <div class="invalid-feedback">Lo siento, Usuario incorrecto.</div>
                        <div class="help-block">Escribe tu usuario</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">Contraseña</label>
                        <input type="password" id="password" class="form-control form-control-lg" placeholder="password" value="password123" required>
                        <div class="invalid-feedback">Lo siento, contraseña incorrecta.</div>
                        <div class="help-block">Escribe tu contraseña</div>
                    </div>
                    <div class="form-group text-left">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="rememberme">
                            <label class="custom-control-label" for="rememberme"> Recuerdame</label>
                        </div>
                    </div>
                    <div class="row no-gutters">
                        <div class="col-lg-6 pr-lg-1 my-2">
                            <button type="submit" class="btn btn-info btn-block btn-lg">Iniciar con <i class="fab fa-google"></i></button>
                        </div>
                        <div class="col-lg-6 pl-lg-1 my-2">
                            <button id="js-login-btn" type="submit" class="btn btn-danger btn-block btn-lg">Iniciar sesión</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="position-absolute pos-bottom pos-left pos-right p-3 text-center text-white">
        2020 © SmartAdmin by&nbsp;<a href='https://www.gotbootstrap.com' class='text-white opacity-40 fw-500' title='gotbootstrap.com' target='_blank'>gotbootstrap.com</a>
    </div>
</div>

<?= Template::endBodyLogin(); ?>