<?php

require __DIR__.'/../vendor/autoload.php';

/**
* Start Eloquent
* or delete this section if you are using Laravel
*/
use Illuminate\Database\Capsule\Manager as Capsule;
$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'newretro',
    'username'  => 'root',
    'password'  => 'password',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

class Prihlasky extends \Onspli\Eladmin\Eloquent\Model
{

    protected $table = 'prihlasky';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $elaTitle = 'Přihlášky';
    protected $elaFasIcon = 'fas fa-clipboard';

}

class Chat extends \Onspli\Eladmin\Eloquent\Model
{

    protected $table = 'chat';
    protected $primaryKey = 'id';
    public $timestamps = false;

}


class Behy extends \Onspli\Eladmin\Eloquent\Model
{

    protected $table = 'behy';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $elaAuthorizedRoles = ['admin'];

}


class Eladmin extends \Onspli\Eladmin\Eladmin
{
  /**
  * Register modules accessible from admin.
  */
  protected $modules = ['prihlasky'=>Prihlasky::class, Behy::class, Chat::class];

  protected $title = 'Retro tábor';
}

$admin = new Eladmin();
$admin->run();
