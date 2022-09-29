<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once($_SERVER['DOCUMENT_ROOT'] . '/vlapp/inc/vlappConfig.php');

class Template
{
    // static public function verificarSesion()
    // {
    //     $usuario = sesion::getparametro('usuario');
    //     if ($usuario == '') {
    //         header('Location: login.php', true);
    //         exit;
    //     }
    // }

    static public function Head($title)
    {
        $html = "<!DOCTYPE html>
                <html lang='" . LANG . "'>
                <head>
                    <meta charset='utf-8'>
                    <title>
                        $title
                    </title>
                    <meta name='description' content='Introduction'>
                    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui'>
                    <meta name='apple-mobile-web-app-capable' content='yes' />
                    <meta name='msapplication-tap-highlight' content='no'>
                    <link id='vendorsbundle' rel='stylesheet' media='screen, print' href='" . CSS . "vendors.bundle.css'>
                    <link id='appbundle' rel='stylesheet' media='screen, print' href='" . CSS . "app.bundle.css'>
                    <link id='mytheme' rel='stylesheet' media='screen, print' href='#'>
                    <link id='myskin' rel='stylesheet' media='screen, print' href='" . CSS . "skins/skin-master.css'>
                    <link rel='apple-touch-icon' sizes='180x180' href='" . IMG . "favicon/apple-touch-icon.png'>
                    <link rel='icon' type='image/png' sizes='32x32' href='" . IMG . "favicon/favicon-32x32.png'>
                    <link rel='mask-icon' href='" . IMG . "favicon/safari-pinned-tab.svg' color='#5bbad5'>
                </head>";
        echo $html;
    }

    static public function startBody()
    {
        ob_start();
?>
        <div class='container body'>
            <div class="main_container">
                <!-- left navigation -->
                <div class="col-md-3 left_col menu_fixed">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="./" class="site_title">
                                <!-- <i class="fa fa-file-text"></i> -->
                                <!-- <span>IRMA</span> -->
                                <span><img src="img/logo_irma.png" alt=""></span>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                        <br>
                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side -print main_menu">
                            <div class="menu_section">
                                <h3>Gestor Documental</h3>
                                <ul class="nav side-menu">
                                    <li>
                                        <a href="./"><i class="fa fa-home"></i>Inicio</span></a>
                                    </li>
                                    <li id="moduloActividades" class="hidden">
                                        <a href="actividades"><i class="fa fa-trello"></i>Actividades</span></a>
                                    </li>
                                    <li id="moduloActivos" class="hidden">
                                        <a href="activos"><i class="fa fa-gear"></i>Activos</span></a>
                                    </li>
                                    <li id="moduloArchivos" class="hidden">
                                        <a href="archivos"><i class="fa fa-folder-open"></i>Archivos</span></a>
                                    </li>
                                    <li id="moduloBernardino" class="hidden"><a><i class="fas fa-certificate" style="margin-right: 10px;"></i>Bernardino<span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li id="submoduloDocumentosBernardino" class=""><a href="https://www.laboratoriorvo.com/bernardino/contrato/documentos.php" target="_blank">Documentos Bernardino</a></li>
                                            <li id="submoduloIngresoBernardino" class=""><a href="https://www.laboratoriorvo.com/bernardino/login.php" target="_blank">Ingreso a Bernardino</a></li>
                                            <li id="submoduloDocumentosBernardino" class=""><a href="documentos-bernardino">Vista Documentos</a></li>
                                        </ul>
                                    </li>
                                    <li id="moduloDocumentos" class="hidden">
                                        <a href="documentos"><i class="fa fa-file"></i>Documentos</span></a>
                                    </li>
                                    <li id="moduloInsumos" class="hidden">
                                        <a href="insumos"><i class="fa fa-list"></i>Insumos</span></a>
                                    </li>
                                    <li id="moduloUsuarios" class="hidden">
                                        <a href="usuarios"><i class="fa fa-user"></i>Usuarios</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /sidebar menu -->
                    </div>
                </div>
                <!-- Menu -->

                <!-- top navigation -->
                <div class="top_nav">
                    <div class="nav_menu">
                        <nav>
                            <div class="nav toggle">
                                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                            </div>
                            <ul class="nav navbar-nav navbar-right">
                                <li class="">
                                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span id="topUsuario">ChivoDev</span>
                                        <span class=" fa fa-angle-down"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                                        <li><a href="javascript:;" onclick="perfil();">Perfil</a></li>
                                        <li><a href="javascript:;" onclick="cerrar_sesion();"><i class="fa fa-sign-out pull-right"></i>Cerrar Sesion</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- /top navigation -->

            <?php
            return ob_get_clean();
        }

        static public function endBody()
        {
            ob_start();
            ?>
                <!-- footer content -->
                <div class="">
                    <footer>
                        <div class="text-center">
                            Desarrollado por <a href="https://chivodev.com">ChivoDev</a>
                            <span> IRMA v1.0</span>
                        </div>
                        <div class="clearfix"></div>
                    </footer>
                </div>
                <!-- /footer content -->
            </div>
        </div>

        <!-- MODAL MOSTRAR PDF -->
        <input type="hidden" id="modalMostrar">
        <div class="modal fade text-uppercase" id="modalPdfGenerado" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="nombrePDF"></h4>
                    </div>
                    <div class="modal-body">
                        <iframe src="" id="ifmPDF" style="width:100%; height:500px;" frameborder="0"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger text-uppercase" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL MOSTRAR PDF -->

        <!-- Modal Confirmacion -->
        <div class="modal fade text-uppercase" id="modalConfirmar" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header header-danger">
                        <h4 class="modal-title">CONFIRMACION</h4>
                    </div>
                    <div class="modal-body" style="">
                        <p>¿Estas seguro de eliminar este item?</p>
                        <p class="msj-validacion animated infinite pulse ocultar">&nbsp;Ingresa el resultado correcto</p>
                        <br>
                        <div class="input-group">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default" id="captchaOperacionPrimerNumero"></button>
                                <button type="button" class="btn btn-default">+</button>
                                <button type="button" class="btn btn-default" id="captchaOperacionSegundoNumero"></button>
                                <button type="button" class="btn btn-default">=</button>
                            </div>
                            <a class="tooltips">
                                <input type="text" class="form-control requerido" title="Ingresa el valor correcto" id="captchaOperacionResultadoComprobar" maxlength="2" oninput="limite_caracteres_animated(this);" pattern="^[0-9\s]+$" data-pattern="Solo se permiten números" data-pattern-replace="[^0-9\s]">
                                <span class="spanValidacion"></span>
                            </a>
                        </div>
                        <input type="hidden" id="captchaOperacionResultado">
                        <input type="hidden" id="idItem">
                        <div style="clear: both;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="btnEliminar" class="btn btn-danger" onclick="validar_cierre();">Continuar</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!-- Fin modal confirmacion -->

        <!-- Profle -->
        <div class="modal fade bs-example-modal-md text-uppercase" id="modalProfile" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="col-md-12 col-sm-12 col-xs-12 profile_details">
                            <div class="well profile_view">
                                <div class="col-sm-12">
                                    <div class="left col-xs-7">
                                        <h2 id="nombre">Hadik Chavez</h2>
                                        <!-- <p><strong>Usuario: </strong><span id="usuario">hadik.chavez</span></p> -->
                                        <ul class="list-unstyled">
                                            <li><i class="fa fa-user" style="margin-right: 10px;"></i><span id="usuario">hadik.chavez</span></li>
                                            <li><i class="fa fa-certificate" style="margin-right: 10px;"></i><span id="procesos">GOL,GOS,DA</span></li>
                                            <li><i class="fa fa-envelope" style="margin-right: 10px;"></i><span id="correo">chavezhadik@gmail.com</span></li>
                                        </ul>
                                    </div>
                                    <div class="right col-xs-5 text-center">
                                        <img src="img/user.png" alt="" class="img-circle img-responsive">
                                    </div>
                                </div>
                                <div class="col-xs-12 bottom text-center">
                                    <div class="col-xs-12 col-sm-12 emphasis">
                                        <h4 class="brief"><i><span id="tipoUsuario">Biel</span></i></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="clear:both;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger text-uppercase" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin profile -->

        <!-- jQuery -->
        <script src="plugins/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="plugins/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- FastClick -->
        <script src="plugins/fastclick/lib/fastclick.js"></script>
        <!-- NProgress -->
        <script src="plugins/nprogress/nprogress.js"></script>
        <!-- bootstrap-progressbar -->
        <script src="plugins/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
        <!-- iCheck -->
        <script src="plugins/iCheck/icheck.min.js"></script>
        <!-- input-mask -->
        <script src="plugins/input-mask/dist/jquery.inputmask.bundle.js"></script>
        <script src="plugins/jQuery-Mask-Plugin-master/src/jquery.mask.js"></script>
        <!-- Moment -->
        <script src="plugins/moment/min/moment.min.js"></script>
        <!-- bootstrap-daterangepicker -->
        <script src="plugins/moment/min/moment.min.js"></script>
        <script src="plugins/moment/locale/es.js"></script>
        <script src="plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
        <!--bootstrap datepícker-->
        <script src="plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js"></script>
        <!-- datatable -->
        <script src="plugins/datatable/jquery.dataTables.js"></script>
        <script src="plugins/datatable/Responsive/dataTables.responsive.js"></script>
        <!-- MaxLenght -->
        <script src="plugins/bootstrap-maxlength/bootstrap-maxlength.js"></script>
        <!-- pNotify -->
        <script src="plugins/pnotify/pnotify.custom.js"></script>
        <script src="scripts/conf-notificaciones.js"></script>
        <!-- Sortable -->
        <script src="plugins/sortable/Sortable.js"></script>
        <!-- validator -->
        <script src="plugins/validator/validator.js"></script>
        <!-- Select2 -->
        <script src="plugins/select2/dist/js/select2.full.min.js"></script>
        <script src="plugins/select2/dist/js/i18n/es.js"></script>
        <!-- SweetAlert2 -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="plugins/bootstrap-calendar-master/components/underscore/underscore.min.js"></script>
        <script src="plugins/bootstrap-calendar-master/js/language/es-CO.js"></script>
        <script src="plugins/bootstrap-calendar-master/js/calendar.js"></script>
        <!-- Custom Theme Scripts -->
        <script src="scripts/globales.js"></script>
        <script src="scripts/utilidades.js"></script>
        <script src="js/custom.js"></script>
        <script src="scripts/validaciones.js"></script>
        <script src="scripts/inicio.js"></script>
        <script src="scripts/login.js"></script>
        <script src="scripts/enter.js"></script>
        <script src="scripts/conf-sortable.js"></script>
        <script src="scripts/conf-bootstrapmaxlenght.js"></script>
        <script src="scripts/conf-datepicker.js"></script>
        <script src="scripts/conf-icheck.js"></script>
        <script src="scripts/conf-input-mask.js"></script>
        <script src="scripts/conf-mask.js"></script>
        <script src="scripts/cargar_select.js"></script>
        <!-- <script src="scripts/conf-fullcalendar.js"></script>
	        <script src="scripts/conf-tuiCallendar.js"></script> -->
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
        </body>

        </html>

<?php
            return ob_get_clean();
        }
    }
