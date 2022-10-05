<?php

declare(strict_types=1);

include_once($_SERVER['DOCUMENT_ROOT'] . '/volapp/inc/volappConfig.php');
include($_SERVER['DOCUMENT_ROOT'] . MODELS . 'modelTest.php');

class TestController
{
    public function getTest(): void
    {
        include($_SERVER['DOCUMENT_ROOT'] . INC . 'db.php');
        $database = new Database();
        $db = $database->getConnection();
        $test = new Test($db);
        $test->selecTest();
    }

    
}
