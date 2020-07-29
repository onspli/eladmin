<?php
use Onspli\Eladmin;

require_once __DIR__ . '/bootstrap.php';


class MyEladmin extends Eladmin\Eladmin {

}

$eladmin = new MyEladmin();
$eladmin->run();
