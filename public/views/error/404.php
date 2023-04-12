<?php

declare(strict_types=1);

include_once($_SERVER['DOCUMENT_ROOT'] . '/inc/volappConfig.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>
        404
    </title>
    <meta name="description" content="Server Error">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- base css -->
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="<?= CSS ?>vendors.bundle.css">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="<?= CSS ?>app.bundle.css">
    <link id="mytheme" rel="stylesheet" media="screen, print" href="#">
    <link id="myskin" rel="stylesheet" media="screen, print" href="<?= CSS ?>skins/skin-master.css">
    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= IMG ?>favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= IMG ?>favicon/favicon-32x32.png">
    <link rel="mask-icon" href="<?= IMG ?>favicon/safari-pinned-tab.svg" color="#5bbad5">
</head>

<body class="mod-bg-1 mod-nav-link ">
    <script src="<?= JS ?>configApp.js"></script>
    <div class="page-wrapper">
        <div class="page-inner">
            <!-- BEGIN Left Aside -->
            <aside class="page-sidebar">
                <div class="page-logo">
                    <a href="<?= VIEW_HREF ?>login/" class="page-logo-link press-scale-down d-flex align-items-center position-relative">
                        <img src="<?= IMG ?>logo.png" alt="SmartAdmin WebApp" aria-roledescription="logo">
                        <span class="page-logo-text mr-1">VolApp ®</span>
                        <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
                    </a>
                </div>
                <!-- BEGIN PRIMARY NAVIGATION -->
                <nav id="js-primary-nav" class="primary-nav" role="navigation">
                    <div class="info-card">
                        <img src="" class="profile-image rounded-circle">
                        <div class="info-card-text">
                            <a href="#" class="d-flex align-items-center text-white">
                                <h2 class="text-truncate text-truncate-sm d-inline-block">
                                    Error 404
                                </h2>
                            </a>
                        </div>
                        <img src="<?= IMG ?>card-backgrounds/banner.png" class="cover" alt="cover">
                    </div>
                    <ul id="js-nav-menu" class="nav-menu">

                    </ul>
                    <div class="filter-message js-filter-message bg-success-600"></div>
                </nav>
                <!-- END PRIMARY NAVIGATION -->
            </aside>
            <!-- END Left Aside -->
            <div class="page-content-wrapper">
                <!-- BEGIN Page Header -->
                <header class="page-header" role="banner">
                    <!-- DOC: nav menu layout change shortcut -->
                    <div class="hidden-md-down dropdown-icon-menu position-relative">
                        <a href="#" class="header-btn btn js-waves-off" data-action="toggle" data-class="nav-function-minify" title="Minimizar Menu" onclick="reajustDatatables();">
                            <i class="ni ni-menu"></i>
                        </a>
                        <!-- <ul>
                                    <li>
                                        <a href="#" class="btn js-waves-off" data-action="toggle" data-class="nav-function-hidden" title="Ocultar Menu">
                                            <i class="ni ni-minify-nav"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="btn js-waves-off" data-action="toggle" data-class="nav-function-fixed" title="Bloquear Menu">
                                            <i class="ni ni-lock-nav"></i>
                                        </a>
                                    </li>
                                </ul> -->
                    </div>
                    <!-- DOC: mobile button appears during mobile width -->
                    <div class="hidden-lg-up">
                        <a href="#" class="header-btn btn press-scale-down" data-action="toggle" data-class="mobile-nav-on">
                            <i class="ni ni-menu"></i>
                        </a>
                    </div>
                    <div class="ml-auto d-flex">
                        <!-- app settings -->
                        <div class="hidden-md-down">
                            <a href="#" class="header-icon" data-toggle="modal" data-target=".js-modal-settings">
                                <i class="fal fa-cog"></i>
                            </a>
                        </div>

                    </div>
                </header>
                <!-- END Page Header -->
                <!-- BEGIN Page Content -->
                <!-- the #js-page-content id is needed for some plugins to initialize -->
                <main id="js-page-content" role="main" class="page-content">
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="position-absolute pos-top pos-left d-none d-sm-block"><span class="js-get-date"></span></li>
                    </ol>
                    <div class="subheader"></div>
                    <div class="h-alt-hf d-flex flex-column align-items-center justify-content-center text-center">
                        <h1 class="page-error color-fusion-500">
                            ERROR <span class="text-gradient">404</span>
                        </h1>
                        <h3 class="fw-500 mb-5 my-4">
                            Lo sentimos, la página a la que intentas acceder no existe!
                        </h3>
                    </div>

                </main>
                <!-- this overlay is activated only when mobile menu is triggered -->
                <div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div> <!-- END Page Content -->
                <!-- BEGIN Page Footer -->
                <footer class="page-footer" role="contentinfo">
                    <div class="d-flex align-items-center flex-1 text-muted">
                        <span class="hidden-md-down fw-700"><?= date('Y') ?> © VOLAPP</span>
                    </div>
                    <div>
                        <ul class="list-table m-0">
                            <li class="pl-3"><a href="#" class="text-secondary fw-700">Licencia</a></li>
                        </ul>
                    </div>
                </footer>
                <!-- END Page Footer -->
                <!-- BEGIN Color profile -->
                <!-- this area is hidden and will not be seen on screens or screen readers -->
                <!-- we use this only for CSS color refernce for JS stuff -->
            </div>
        </div>
    </div>
    <nav class="shortcut-menu d-none d-sm-block">
        <input type="checkbox" class="menu-open" name="menu-open" id="menu_open" />
        <label for="menu_open" class="menu-open-button ">
            <span class="app-shortcut-icon d-block"></span>
        </label>
        <a href="#" class="menu-item btn" data-toggle="tooltip" data-placement="left" title="Arriba">
            <i class="fal fa-arrow-up"></i>
        </a>
        <a onclick="cerrarSesion();" class="menu-item btn" data-toggle="tooltip" data-placement="left" title="Salir">
            <i class="fal fa-sign-out"></i>
        </a>
        <a href="#" class="menu-item btn" data-action="app-fullscreen" data-toggle="tooltip" data-placement="left" title="Pantalla Completa">
            <i class="fal fa-expand"></i>
        </a>
        <a href="#" class="menu-item btn" data-action="app-print" data-toggle="tooltip" data-placement="left" title="Imprimir Pagina">
            <i class="fal fa-print"></i>
        </a>
    </nav>
    <!-- END Quick Menu -->
    <!-- BEGIN Page Settings -->
    <div class="modal fade js-modal-settings modal-backdrop-transparent" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-right modal-md">
            <div class="modal-content">
                <div class="dropdown-header bg-trans-gradient d-flex justify-content-center align-items-center w-100">
                    <h4 class="m-0 text-center color-white">
                        Opciones de diseño
                        <small class="mb-0 opacity-80">Configuración de la interfaz de usuario</small>
                    </h4>
                    <button type="button" class="close text-white position-absolute pos-top pos-right p-2 m-1 mr-2" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="settings-panel">
                        <div class="mt-4 d-table w-100 px-5">
                            <div class="d-table-cell align-middle">
                                <h5 class="p-0">
                                    Diseño de la aplicación
                                </h5>
                            </div>
                        </div>
                        <div class="list" id="fh">
                            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="header-function-fixed"></a>
                            <span class="onoffswitch-title">Encabezado fijo</span>
                            <span class="onoffswitch-title-desc">el encabezado está en un fijo en todo momento</span>
                        </div>
                        <div class="list" id="nff">
                            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="nav-function-fixed"></a>
                            <span class="onoffswitch-title">Navegación fija</span>
                            <span class="onoffswitch-title-desc">el panel izquierdo está fijo</span>
                        </div>
                        <div class="list" id="nfm">
                            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="nav-function-minify"></a>
                            <span class="onoffswitch-title">Minimizar navegación</span>
                            <span class="onoffswitch-title-desc">navegación sesgada para maximizar el espacio</span>
                        </div>
                        <div class="list" id="nfh">
                            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="nav-function-hidden"></a>
                            <span class="onoffswitch-title">Ocultar navegación</span>
                            <span class="onoffswitch-title-desc">haga rodar el mouse sobre el borde para revelar</span>
                        </div>
                        <div class="list" id="nft">
                            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="nav-function-top"></a>
                            <span class="onoffswitch-title">Navegación superior</span>
                            <span class="onoffswitch-title-desc">reubicar el panel izquierdo en la parte superior</span>
                        </div>
                        <div class="list" id="fff">
                            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="footer-function-fixed"></a>
                            <span class="onoffswitch-title">Pie de página fijo</span>
                            <span class="onoffswitch-title-desc">el pie de página es fijo</span>
                        </div>
                        <div class="list" id="mmb">
                            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-main-boxed"></a>
                            <span class="onoffswitch-title">Diseño en caja</span>
                            <span class="onoffswitch-title-desc">encapsula a un contenedorr</span>
                        </div>
                        <div class="expanded">
                            <ul class="mb-3 mt-1">
                                <li>
                                    <div class="bg-fusion-50" data-action="toggle" data-class="mod-bg-1"></div>
                                </li>
                                <li>
                                    <div class="bg-warning-200" data-action="toggle" data-class="mod-bg-2"></div>
                                </li>
                                <li>
                                    <div class="bg-primary-200" data-action="toggle" data-class="mod-bg-3"></div>
                                </li>
                                <li>
                                    <div class="bg-success-300" data-action="toggle" data-class="mod-bg-4"></div>
                                </li>
                                <li>
                                    <div class="bg-white border" data-action="toggle" data-class="mod-bg-none"></div>
                                </li>
                            </ul>
                            <div class="list" id="mbgf">
                                <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-fixed-bg"></a>
                                <span class="onoffswitch-title">fondo fijo</span>
                            </div>
                        </div>
                        <div class="mt-4 d-table w-100 px-5">
                            <div class="d-table-cell align-middle">
                                <h5 class="p-0">
                                    Menú móvil
                                </h5>
                            </div>
                        </div>
                        <div class="list" id="nmp">
                            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="nav-mobile-push"></a>
                            <span class="onoffswitch-title">Empujar contenido</span>
                            <span class="onoffswitch-title-desc">Contenido empujado en el menú revelado</span>
                        </div>
                        <div class="list" id="nmno">
                            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="nav-mobile-no-overlay"></a>
                            <span class="onoffswitch-title">Sin superposición</span>
                            <span class="onoffswitch-title-desc">elimina la malla en el menú revelado</span>
                        </div>
                        <div class="list" id="sldo">
                            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="nav-mobile-slide-out"></a>
                            <span class="onoffswitch-title">fuera del lienzo <sup>(beta)</sup></span>
                            <span class="onoffswitch-title-desc">Menú de superposición de contenido</span>
                        </div>
                        <div class="mt-4 d-table w-100 px-5">
                            <div class="d-table-cell align-middle">
                                <h5 class="p-0">
                                    Accesibilidad
                                </h5>
                            </div>
                        </div>
                        <div class="list" id="mbf">
                            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-bigger-font"></a>
                            <span class="onoffswitch-title">Fuente de contenido más grande</span>
                            <span class="onoffswitch-title-desc">las fuentes de contenido son más grandes para facilitar la lectura</span>
                        </div>
                        <div class="list" id="mhc">
                            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-high-contrast"></a>
                            <span class="onoffswitch-title">Texto de alto contraste (WCAG 2 AA)</span>
                            <span class="onoffswitch-title-desc">4.5:1 relación de contraste de texto</span>
                        </div>
                        <div class="list" id="mcb">
                            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-color-blind"></a>
                            <span class="onoffswitch-title">Daltonismo <sup>(beta)</sup> </span>
                            <span class="onoffswitch-title-desc">deficiencia de la visión del color</span>
                        </div>
                        <div class="list" id="mpc">
                            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-pace-custom"></a>
                            <span class="onoffswitch-title">Precargador interior</span>
                            <span class="onoffswitch-title-desc">el precargador estará dentro del contenido</span>
                        </div>
                        <div class="list" id="mpi">
                            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-panel-icon"></a>
                            <span class="onoffswitch-title">Iconos de SmartPanel (no paneles)</span>
                            <span class="onoffswitch-title-desc">los botones del panel inteligente aparecerán como iconos</span>
                        </div>
                        <div class="mt-4 d-table w-100 px-5">
                            <div class="d-table-cell align-middle">
                                <h5 class="p-0">
                                    Modificaciones globales
                                </h5>
                            </div>
                        </div>
                        <div class="list" id="mcbg">
                            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-clean-page-bg"></a>
                            <span class="onoffswitch-title">Limpiar el fondo de la página</span>
                            <span class="onoffswitch-title-desc">agrega más espacios en blanco</span>
                        </div>
                        <div class="list" id="mhni">
                            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-hide-nav-icons"></a>
                            <span class="onoffswitch-title">Ocultar iconos de navegación</span>
                            <span class="onoffswitch-title-desc">iconos de navegación invisibles</span>
                        </div>
                        <div class="list" id="dan">
                            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-disable-animation"></a>
                            <span class="onoffswitch-title">Deshabilitar animación CSS</span>
                            <span class="onoffswitch-title-desc">Animaciones basadas en CSS deshabilitadas</span>
                        </div>
                        <div class="list" id="mhic">
                            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-hide-info-card"></a>
                            <span class="onoffswitch-title">Ocultar tarjeta de información</span>
                            <span class="onoffswitch-title-desc">oculta la tarjeta de información del panel izquierdo</span>
                        </div>
                        <div class="list" id="mlph">
                            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-lean-subheader"></a>
                            <span class="onoffswitch-title">Subheader magro</span>
                            <span class="onoffswitch-title-desc">encabezado de página distinguido</span>
                        </div>
                        <div class="list" id="mnl">
                            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-nav-link"></a>
                            <span class="onoffswitch-title">Navegación jerárquica</span>
                            <span class="onoffswitch-title-desc">Desglose claro de enlaces de navegación</span>
                        </div>
                        <div class="list" id="mdn">
                            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-nav-dark"></a>
                            <span class="onoffswitch-title">Navegación oscura</span>
                            <span class="onoffswitch-title-desc">El fondo de navegación está oscuro</span>
                        </div>
                        <hr class="mb-0 mt-4">
                        <div class="mt-4 d-table w-100 pl-5 pr-3">
                            <div class="d-table-cell align-middle">
                                <h5 class="p-0">
                                    Tamaño de fuente global
                                </h5>
                            </div>
                        </div>
                        <div class="list mt-1">
                            <div class="btn-group btn-group-sm btn-group-toggle my-2" data-toggle="buttons">
                                <label class="btn btn-default btn-sm" data-action="toggle-swap" data-class="root-text-sm" data-target="html">
                                    <input type="radio" name="changeFrontSize"> SM
                                </label>
                                <label class="btn btn-default btn-sm" data-action="toggle-swap" data-class="root-text" data-target="html">
                                    <input type="radio" name="changeFrontSize" checked=""> MD
                                </label>
                                <label class="btn btn-default btn-sm" data-action="toggle-swap" data-class="root-text-lg" data-target="html">
                                    <input type="radio" name="changeFrontSize"> LG
                                </label>
                                <label class="btn btn-default btn-sm" data-action="toggle-swap" data-class="root-text-xl" data-target="html">
                                    <input type="radio" name="changeFrontSize"> XL
                                </label>
                            </div>
                            <span class="onoffswitch-title-desc d-block mb-0">Cambio <strong>root</strong> tamaño de fuente para efecto rem
                                valores (se restablece al actualizar la página)</span>
                        </div>
                        <hr class="mb-0 mt-4">
                        <div class="mt-4 d-table w-100 pl-5 pr-3">
                            <div class="d-table-cell align-middle">
                                <h5 class="p-0 pr-2 d-flex">
                                    colores del tema
                                </h5>
                            </div>
                        </div>
                        <div class="expanded theme-colors pl-5 pr-3">
                            <ul class="m-0">
                                <li>
                                    <a href="#" id="myapp-0" data-action="theme-update" data-themesave data-theme="" data-toggle="tooltip" data-placement="top" title="Wisteria (base css)" data-original-title="Wisteria (base css)"></a>
                                </li>
                                <li>
                                    <a href="#" id="myapp-1" data-action="theme-update" data-themesave data-theme="<?= CSS ?>themes/cust-theme-1.css" data-toggle="tooltip" data-placement="top" title="Tapestry" data-original-title="Tapestry"></a>
                                </li>
                                <li>
                                    <a href="#" id="myapp-2" data-action="theme-update" data-themesave data-theme="<?= CSS ?>themes/cust-theme-2.css" data-toggle="tooltip" data-placement="top" title="Atlantis" data-original-title="Atlantis"></a>
                                </li>
                                <li>
                                    <a href="#" id="myapp-3" data-action="theme-update" data-themesave data-theme="<?= CSS ?>themes/cust-theme-3.css" data-toggle="tooltip" data-placement="top" title="Indigo" data-original-title="Indigo"></a>
                                </li>
                                <li>
                                    <a href="#" id="myapp-4" data-action="theme-update" data-themesave data-theme="<?= CSS ?>themes/cust-theme-4.css" data-toggle="tooltip" data-placement="top" title="Dodger Blue" data-original-title="Dodger Blue"></a>
                                </li>
                                <li>
                                    <a href="#" id="myapp-5" data-action="theme-update" data-themesave data-theme="<?= CSS ?>themes/cust-theme-5.css" data-toggle="tooltip" data-placement="top" title="Tradewind" data-original-title="Tradewind"></a>
                                </li>
                                <li>
                                    <a href="#" id="myapp-6" data-action="theme-update" data-themesave data-theme="<?= CSS ?>themes/cust-theme-6.css" data-toggle="tooltip" data-placement="top" title="Cranberry" data-original-title="Cranberry"></a>
                                </li>
                                <li>
                                    <a href="#" id="myapp-7" data-action="theme-update" data-themesave data-theme="<?= CSS ?>themes/cust-theme-7.css" data-toggle="tooltip" data-placement="top" title="Oslo Gray" data-original-title="Oslo Gray"></a>
                                </li>
                                <li>
                                    <a href="#" id="myapp-8" data-action="theme-update" data-themesave data-theme="<?= CSS ?>themes/cust-theme-8.css" data-toggle="tooltip" data-placement="top" title="Chetwode Blue" data-original-title="Chetwode Blue"></a>
                                </li>
                                <li>
                                    <a href="#" id="myapp-9" data-action="theme-update" data-themesave data-theme="<?= CSS ?>themes/cust-theme-9.css" data-toggle="tooltip" data-placement="top" title="Apricot" data-original-title="Apricot"></a>
                                </li>
                                <li>
                                    <a href="#" id="myapp-10" data-action="theme-update" data-themesave data-theme="<?= CSS ?>themes/cust-theme-10.css" data-toggle="tooltip" data-placement="top" title="Blue Smoke" data-original-title="Blue Smoke"></a>
                                </li>
                                <li>
                                    <a href="#" id="myapp-11" data-action="theme-update" data-themesave data-theme="<?= CSS ?>themes/cust-theme-11.css" data-toggle="tooltip" data-placement="top" title="Green Smoke" data-original-title="Green Smoke"></a>
                                </li>
                                <li>
                                    <a href="#" id="myapp-12" data-action="theme-update" data-themesave data-theme="<?= CSS ?>themes/cust-theme-12.css" data-toggle="tooltip" data-placement="top" title="Wild Blue Yonder" data-original-title="Wild Blue Yonder"></a>
                                </li>
                                <li>
                                    <a href="#" id="myapp-13" data-action="theme-update" data-themesave data-theme="<?= CSS ?>themes/cust-theme-13.css" data-toggle="tooltip" data-placement="top" title="Emerald" data-original-title="Emerald"></a>
                                </li>
                                <li>
                                    <a href="#" id="myapp-14" data-action="theme-update" data-themesave data-theme="<?= CSS ?>themes/cust-theme-14.css" data-toggle="tooltip" data-placement="top" title="Supernova" data-original-title="Supernova"></a>
                                </li>
                                <li>
                                    <a href="#" id="myapp-15" data-action="theme-update" data-themesave data-theme="<?= CSS ?>themes/cust-theme-15.css" data-toggle="tooltip" data-placement="top" title="Hoki" data-original-title="Hoki"></a>
                                </li>
                            </ul>
                        </div>
                        <hr class="mb-0 mt-4">
                        <div class="mt-4 d-table w-100 pl-5 pr-3">
                            <div class="d-table-cell align-middle">
                                <h5 class="p-0 pr-2 d-flex">
                                    Modos de tema
                                </h5>
                            </div>
                        </div>
                        <div class="pl-5 pr-3 py-3">
                            <div class="ie-only alert alert-warning d-none">
                                <h6>Problema de Internet Explorer</h6>
                                Es posible que este componente en particular no funcione como se esperaba en Internet Explorer. Úselo con precaución.
                            </div>
                            <div class="row no-gutters">
                                <div class="col-4 pr-2 text-center">
                                    <div id="skin-default" data-action="toggle-replace" data-replaceclass="mod-skin-light mod-skin-dark" data-class="" data-toggle="tooltip" data-placement="top" title="" class="d-flex bg-white border border-primary rounded overflow-hidden text-success js-waves-on" data-original-title="Default Mode" style="height: 80px">
                                        <div class="bg-primary-600 bg-primary-gradient px-2 pt-0 border-right border-primary"></div>
                                        <div class="d-flex flex-column flex-1">
                                            <div class="bg-white border-bottom border-primary py-1"></div>
                                            <div class="bg-faded flex-1 pt-3 pb-3 px-2">
                                                <div class="py-3" style="background:url(' <?= IMG ?>demo/s-1.png') top left no-repeat;background-size: 100%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    Normal
                                </div>
                                <div class="col-4 px-1 text-center">
                                    <div id="skin-light" data-action="toggle-replace" data-replaceclass="mod-skin-dark" data-class="mod-skin-light" data-toggle="tooltip" data-placement="top" title="" class="d-flex bg-white border border-secondary rounded overflow-hidden text-success js-waves-on" data-original-title="Light Mode" style="height: 80px">
                                        <div class="bg-white px-2 pt-0 border-right border-"></div>
                                        <div class="d-flex flex-column flex-1">
                                            <div class="bg-white border-bottom border- py-1"></div>
                                            <div class="bg-white flex-1 pt-3 pb-3 px-2">
                                                <div class="py-3" style="background:url(' <?= IMG ?>demo/s-1.png') top left no-repeat;background-size: 100%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    Blanco
                                </div>
                                <div class="col-4 pl-2 text-center">
                                    <div id="skin-dark" data-action="toggle-replace" data-replaceclass="mod-skin-light" data-class="mod-skin-dark" data-toggle="tooltip" data-placement="top" title="" class="d-flex bg-white border border-dark rounded overflow-hidden text-success js-waves-on" data-original-title="Dark Mode" style="height: 80px">
                                        <div class="bg-fusion-500 px-2 pt-0 border-right"></div>
                                        <div class="d-flex flex-column flex-1">
                                            <div class="bg-fusion-600 border-bottom py-1"></div>
                                            <div class="bg-fusion-300 flex-1 pt-3 pb-3 px-2">
                                                <div class="py-3 opacity-30" style="background:url(' <?= IMG ?>demo/s-1.png') top left no-repeat;background-size: 100%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    Negro
                                </div>
                            </div>
                        </div>
                        <hr class="mb-0 mt-4">
                        <div class="pl-5 pr-3 py-3 bg-faded">
                            <div class="row no-gutters">
                                <div class="col-6 pr-1">
                                    <a href="#" class="btn btn-outline-danger fw-500 btn-block" data-action="app-reset">Reiniciar ajustes</a>
                                </div>
                                <div class="col-6 pl-1">
                                    <a href="#" class="btn btn-danger fw-500 btn-block" data-action="factory-reset">Restablecimiento</a>
                                </div>
                            </div>
                        </div>
                    </div> <span id="saving"></span>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= JS ?>vendors.bundle.js"></script>
    <script src="<?= JS ?>app.bundle.js"></script>
</body>
<!-- END Body -->

</html>