<?php
require __DIR__.'/../../vendor/autoload.php';


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Onspli\Eladmin\Eladmin;
use Onspli\Eladmin\Module\Eloquent\Crud;

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

/**
* Events schema:
* $table->increments('id');
* $table->string('name');
* $table->datetime('when');
* $table->string('where');
* $table->integer('price');
* $table->text('description');
* $table->timestamps();
* $table->softDeletes();
*/
class Event extends Model
{
  use Crud;
  use SoftDeletes;
}


/**
* Registrations schema:
* $table->increments('id');
* $table->string('name');
* $table->integer('event_id')->unsigned();
* $table->string('email');
* $table->string('status');
* $table->timestamps();
* $table->softDeletes();
*/
class Registration extends Model
{
  use Crud;
  use SoftDeletes;
}

/**
* Eladmin configuration
*/
class MyEladmin extends Eladmin
{
  /**
  * Cache directory used by template engine
  */
  protected $cache = __DIR__.'/../../cache';

  /**
  * Add modules to the administration.
  */
  protected $modules = [Registration::class, Event::class];

  public $consecutive = __DIR__ . '/test.js';

  protected function testinit(){

    Capsule::schema()->dropIfExists('elausers');
    Capsule::schema()->dropIfExists('events');
    Capsule::schema()->dropIfExists('registrations');

    Capsule::schema()->create('events', function ($table) {
      $table->increments('id');
      $table->string('name');
      $table->datetime('when');
      $table->string('where');
      $table->integer('price');
      $table->text('description');
      $table->timestamps();
      $table->softDeletes();
    });

    Capsule::schema()->create('registrations', function ($table) {
      $table->increments('id');
      $table->string('name');
      $table->integer('event_id')->unsigned();
      $table->string('email');
      $table->string('status');
      $table->timestamps();
      $table->softDeletes();
    });
    echo "reset";
  }
}

/**
* Run Eladmin
*/
$myEladmin = new MyEladmin();
$myEladmin->run();
