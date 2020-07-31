<?php
require_once(__DIR__ . '/../eloquent_models/bootstrap.php');
use Onspli\Eladmin;

class Admin extends Eladmin\Core {

protected $auth = Eladmin\Auth\EloquentUser\Module::class;

}

$admin = new Admin();
$admin->run();
