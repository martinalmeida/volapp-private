<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/volapp/inc/volappConfig.php');
include_once(VIEW_CONTROLLER);

use View\ViewController;

$view = new ViewController('login');

$view->initializationView();
?>

<div class="row">
    <div class="col col-md-6 col-lg-7 hidden-sm-down">
        <h2 class="fs-xxl fw-500 mt-4 text-white">
            <img src="../../../resources/assets/img/logo-login.png" alt="VolApp">
            <small class="h3 fw-300 mt-2 mb-5 text-white opacity-60 text-center">
                <b>Soluciones de software para negocios orientados al transporte de carga pesada.</b>
            </small>
        </h2>
        <!-- <a href="#" class="fs-lg fw-500 text-white opacity-70">Ver más &gt;&gt;</a> -->
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
            <form id="frmLogin">
                <div class="form-group">
                    <label class="form-label" for="usuarioLogin">Correo</label>
                    <input type="email" onKeyPress="if(this.value.length==100)return false;" min="0" class="form-control form-control-lg" id="usuarioLogin" name="usuarioLogin" placeholder="Ingresa tu email" required>
                    <div class="invalid-feedback">Falta Correo Electronico.</div>
                    <div class="help-block">Escribe tu email</div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="contraseniaLogin">Contraseña</label>
                    <input type="password" onKeyPress="if(this.value.length==100)return false;" min="0" class="form-control form-control-lg" id="contraseniaLogin" name="contraseniaLogin" placeholder="Ingresa tu contraseña" required>
                    <div class="invalid-feedback">Falta contraseña.</div>
                    <div class="help-block">Escribe tu contraseña</div>
                </div>

                <!-- Inicio Spinner de carga -->
                <div class="panel-container show">
                    <div class="panel-content d-flex justify-content-center">
                        <div class="demo" id="spinnerLogin">

                        </div>
                    </div>
                </div>
                <!-- fin Spinner de carga -->

                <div class="form-group text-left">
                    <!-- <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="rememberme">
                            <label class="custom-control-label" for="rememberme"> Recuerdame</label>
                        </div> -->
                </div>
                <div class="row no-gutters">
                    <div class="col-lg-12 pr-lg-1 my-2">
                        <a class="btn btn-info btn-block btn-lg text-white" id="btnLoginIngresar" onclick="login('frmLogin');">Iniciar Sesión <i class="fa-solid fa-right-to-bracket"></i></a>
                    </div>
                    <!-- <div class="col-lg-6 pl-lg-1 my-2">
                            <button id="js-login-btn" type="submit" class="btn btn-danger btn-block btn-lg">Iniciar sesión</button>
                        </div> -->
                </div>
            </form>
        </div>
    </div>
</div>

<?= $view->finalizeView();
