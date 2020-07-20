<?php
require_once __DIR__ . '/../EladminTest.php';

class MyEladmin extends EladminTest {

}

$eladmin = new MyEladmin();
$eladmin->run();
