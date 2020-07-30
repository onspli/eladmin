<?php
require_once(__DIR__ . '/../eloquent_models/bootstrap.php');
use Onspli\Eladmin;

class Admin extends Eladmin\Core {

}

$admin = new Admin();
$admin->run();
