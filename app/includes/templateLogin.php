<?php

declare(strict_types=1);

class TemplateLogin
{
    static public function head($title)
    {
        ob_start();
?>
        <!DOCTYPE html>
        <html lang="<?= LANG ?>">

        <head>
            <meta charset="utf-8">
            <title>
                <?= $title ?>
            </title>
            <meta name="description" content="Introduction">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
            <meta name="apple-mobile-web-app-capable" content="yes" />
            <meta name="msapplication-tap-highlight" content="no">
            <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="<?= CSS ?>vendors.bundle.css">
            <link id="appbundle" rel="stylesheet" media="screen, print" href="<?= CSS ?>app.bundle.css">
            <link id="mytheme" rel="stylesheet" media="screen, print" href="#">
            <link id="myskin" rel="stylesheet" media="screen, print" href="<?= CSS ?>skins/skin-master.css">
            <link rel="apple-touch-icon" sizes="180x180" href="<?= IMG ?>favicon/apple-touch-icon.png">
            <link rel="icon" type="image/png" sizes="32x32" href="<?= IMG ?>favicon/favicon-32x32.png">
            <link rel="mask-icon" href="<?= IMG ?>favicon/safari-pinned-tab.svg" color="#5bbad5">
        </head>
    <?php
        return ob_get_clean();
    }

    static public function startBody()
    {
        ob_start();
    ?>

        <body>
            <div class="page-wrapper auth">
                <div class="page-inner bg-brand-gradient">
                    <div class="page-content-wrapper bg-transparent m-6">
                        <div class="flex-1" style="background: url(<?= IMG ?>/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
                            <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
                            <?php
                            return ob_get_clean();
                        }

                        static public function endBody($form, $boton)
                        {
                            ob_start();
                            ?>
                                <div class="position-absolute pos-bottom pos-left pos-right p-3 text-center text-white m-4">
                                    <?= date('Y') ?> © VOLAPP
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="<?= JS ?>vendors.bundle.js?v=<?= rand() ?>"></script>
            <script src="<?= JS ?>app.bundle.js?v=<?= rand() ?>"></script>
            <script src="<?= JS ?>notifications/sweetalert2/sweetalert2@9.js"></script>
            <script src="<?= JS ?>validaciones.js?v=<?= rand() ?>"></script>
            <script src="<?= JS ?>globales.js?v=<?= rand() ?>"></script>
            <script>
                $('#<?= $boton ?>').click(function(event) {
                    var form = $('#<?= $form ?>')
                    if (form[0].checkValidity() === false) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.addClass('was-validated');
                });
            </script>
        </body>

        </html>
    <?php
                            return ob_get_clean();
                        }

                        static public function azyncScript($nameScript)
                        {
                            ob_start();
    ?>
        <script src="<?= JSAJAX . $nameScript ?>Async.js?v=<?= rand() ?>"></script>
<?php
                            return ob_get_clean();
                        }
                    }
