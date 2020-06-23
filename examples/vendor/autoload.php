<?php

require __DIR__.'/../../vendor/autoload.php';

/**
* Start Eloquent
* or delete this section if you are using Laravel
*/
use Illuminate\Database\Capsule\Manager as Capsule;
$capsule = new Capsule;
$capsule->addConnection([
      'driver'   => 'sqlite',
      'database' => __DIR__.'/test.sqlite',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();
