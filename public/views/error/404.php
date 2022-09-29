<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/vlapp/inc/vlappConfig.php');
include_once($_SERVER['DOCUMENT_ROOT'] . INCLUDES . 'template.php');
Template::Head('404');
Template::startBody();
?>

<div class="h-alt-hf d-flex flex-column align-items-center justify-content-center text-center">
    <h1 class="page-error color-fusion-500">
        ERROR <span class="text-gradient">404</span>
        <small class="fw-500">
            Something <u>went</u> wrong!
        </small>
    </h1>
    <h3 class="fw-500 mb-5">
        You have experienced a technical error. We apologize.
    </h3>
    <h4>
        We are working hard to correct this issue. Please wait a few moments and try your search again.
        <br>In the meantime, check out whats new on SmartAdmin WebApp:
    </h4>
</div>

<?= Template::endBody(); ?>