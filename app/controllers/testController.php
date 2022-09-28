<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/vlapp/inc/vlappConfig.php');
include(MODELS . 'modelTest.php');

class TestController
{
    public function getTest()
    {
        include(INC . 'db.php');
        $database = new Database();
        $db = $database->getConnection();
        $test = new Test($db);
        $test->selecTest();
        return $test;
    }
}
