<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/volapp/inc/volappConfig.php');
include($_SERVER['DOCUMENT_ROOT'] . MODELS . 'modelTest.php');

class TestController
{
    public function getTest()
    {
        include($_SERVER['DOCUMENT_ROOT'] . INC . 'db.php');
        $database = new Database();
        $db = $database->getConnection();
        $test = new Test($db);
        $test->selecTest();
        return $test;
    }
}
