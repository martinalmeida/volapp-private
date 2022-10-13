<?php

declare(strict_types=1);

class TemplateLogin
{
    static public function head($title)
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
                    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css' integrity='sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==' crossorigin='anonymous' referrerpolicy='no-referrer' />
                </head>";
        echo $html;
    }

    static public function startBody()
    {
        $html =  "<body>
                    <script>
                        'use strict';
                        var classHolder = document.getElementsByTagName('BODY')[0],
                            themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) : {},
                            themeURL = themeSettings.themeURL || '',
                            themeOptions = themeSettings.themeOptions || '';
                        if (themeSettings.themeOptions) {
                            classHolder.className = themeSettings.themeOptions;
                            console.log('%c✔ Theme settings loaded', 'color: #148f32');
                        } else {
                            console.log('%c✔ Heads up! Theme settings is empty or does not exist, loading default settings...', 'color: #C39BD3');
                        }
                        if (themeSettings.themeURL && !document.getElementById('mytheme')) {
                            var cssfile = document.createElement('link');
                            cssfile.id = 'mytheme';
                            cssfile.rel = 'stylesheet';
                            cssfile.href = themeURL;
                            document.getElementsByTagName('head')[0].appendChild(cssfile);
                
                        } else if (themeSettings.themeURL && document.getElementById('mytheme')) {
                            document.getElementById('mytheme').href = themeSettings.themeURL;
                        }
                        var saveSettings = function() {
                            themeSettings.themeOptions = String(classHolder.className).split(/[^\w-]+/).filter(function(item) {
                                return /^(nav|header|footer|mod|display)-/i.test(item);
                            }).join(' ');
                            if (document.getElementById('mytheme')) {
                                themeSettings.themeURL = document.getElementById('mytheme').getAttribute('href');
                            };
                            localStorage.setItem('themeSettings', JSON.stringify(themeSettings));
                        }
                        var resetSettings = function() {
                            localStorage.setItem('themeSettings', '');
                        }
                    </script>
                    <div class='page-wrapper auth'>
                        <div class='page-inner bg-brand-gradient'>
                            <div class='page-content-wrapper bg-transparent m-0'>
                                <div class='height-10 w-100 shadow-lg px-4 bg-brand-gradient'>
                                    <div class='d-flex align-items-center container p-0'>
                                        <div class='page-logo width-mobile-auto m-0 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9 border-0'>
                                            <a href='javascript:void(0)' class='page-logo-link press-scale-down d-flex align-items-center'>
                                                <img src='" . IMG . "/logo.png' alt='SmartAdmin WebApp' aria-roledescription='logo'>
                                                <span class='page-logo-text mr-1'><b></b></span>
                                            </a>
                                        </div>
                                        <a class='btn-link text-white ml-auto'>
                                            <b>Bienvenidos</b>
                                        </a>
                                    </div>
                                </div>
                                <div class='flex-1' style='background: url(" . IMG . "/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;'>
                                <div class='container py-4 py-lg-5 my-lg-5 px-4 px-sm-0'>";
        echo $html;
    }

    static public function endBody($form, $boton)
    {
        $html = "<div class='position-absolute pos-bottom pos-left pos-right p-3 text-center text-white'>
                    <!-- 2022 © volapp by&nbsp;<a href='' class='text-white opacity-40 fw-500' title='gotbootstrap.com' target='_blank'>volapp</a> -->
                    2022 © VOLAPP
                </div>
                </div>
                </div>
                    </div>
                    </div>
                    </div>
                    <p id='js-color-profile' class='d-none'>
                        <span class='color-primary-50'></span>
                        <span class='color-primary-100'></span>
                        <span class='color-primary-200'></span>
                        <span class='color-primary-300'></span>
                        <span class='color-primary-400'></span>
                        <span class='color-primary-500'></span>
                        <span class='color-primary-600'></span>
                        <span class='color-primary-700'></span>
                        <span class='color-primary-800'></span>
                        <span class='color-primary-900'></span>
                        <span class='color-info-50'></span>
                        <span class='color-info-100'></span>
                        <span class='color-info-200'></span>
                        <span class='color-info-300'></span>
                        <span class='color-info-400'></span>
                        <span class='color-info-500'></span>
                        <span class='color-info-600'></span>
                        <span class='color-info-700'></span>
                        <span class='color-info-800'></span>
                        <span class='color-info-900'></span>
                        <span class='color-danger-50'></span>
                        <span class='color-danger-100'></span>
                        <span class='color-danger-200'></span>
                        <span class='color-danger-300'></span>
                        <span class='color-danger-400'></span>
                        <span class='color-danger-500'></span>
                        <span class='color-danger-600'></span>
                        <span class='color-danger-700'></span>
                        <span class='color-danger-800'></span>
                        <span class='color-danger-900'></span>
                        <span class='color-warning-50'></span>
                        <span class='color-warning-100'></span>
                        <span class='color-warning-200'></span>
                        <span class='color-warning-300'></span>
                        <span class='color-warning-400'></span>
                        <span class='color-warning-500'></span>
                        <span class='color-warning-600'></span>
                        <span class='color-warning-700'></span>
                        <span class='color-warning-800'></span>
                        <span class='color-warning-900'></span>
                        <span class='color-success-50'></span>
                        <span class='color-success-100'></span>
                        <span class='color-success-200'></span>
                        <span class='color-success-300'></span>
                        <span class='color-success-400'></span>
                        <span class='color-success-500'></span>
                        <span class='color-success-600'></span>
                        <span class='color-success-700'></span>
                        <span class='color-success-800'></span>
                        <span class='color-success-900'></span>
                        <span class='color-fusion-50'></span>
                        <span class='color-fusion-100'></span>
                        <span class='color-fusion-200'></span>
                        <span class='color-fusion-300'></span>
                        <span class='color-fusion-400'></span>
                        <span class='color-fusion-500'></span>
                        <span class='color-fusion-600'></span>
                        <span class='color-fusion-700'></span>
                        <span class='color-fusion-800'></span>
                        <span class='color-fusion-900'></span>
                    </p>
                    <script src='" . JS . "vendors.bundle.js?v=" . rand() . "'></script>
                    <script src='" . JS . "app.bundle.js?v=" . rand() . "'></script>
                    <script src='" . JS . "notifications/sweetalert2/sweetalert2@9.js'></script>
                    <script src='" . JS . "validaciones.js?v=" . rand() . "'></script>
                    <script src='" . JS . "globales.js?v=" . rand() . "'></script>
                    <script>
                        $('#" . $boton . "').click(function(event) {
                            var form = $('#" . $form . "')
                            if (form[0].checkValidity() === false) {
                                event.preventDefault()
                                event.stopPropagation()
                            }
                            form.addClass('was-validated');
                        });
                    </script>
                    </body>
                    </html>";
        echo $html;
    }

    static public function azyncScript($nameScript)
    {
        $html = '<script src="' . JSAJAX . $nameScript . 'Async.js?v=' . rand() . '"></script>';

        return $html;
    }
}
