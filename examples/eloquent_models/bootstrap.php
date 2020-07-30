<?php
require_once(__DIR__ . '/../../vendor/autoload.php');

require_once(__DIR__ . '/model/Event.php');
require_once(__DIR__ . '/model/Registration.php');

$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection([
      'driver'   => 'sqlite',
      'database' => __DIR__ . '/test.sqlite',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();
