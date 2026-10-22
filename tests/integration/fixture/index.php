<?php
/**
* Eladmin application used by integration tests. Served by PHP built-in server,
* ELADMIN_TEST_DIR environment variable points to a writable working directory.
*/
require_once __DIR__ . '/../../../vendor/autoload.php';

use Onspli\Eladmin;
use Illuminate\Database\Capsule\Manager as Capsule;

$workDir = getenv('ELADMIN_TEST_DIR');
if (!$workDir || !is_dir($workDir)) {
  http_response_code(500);
  exit('ELADMIN_TEST_DIR is not set.');
}

// laravel doesn't create missing sqlite database file
touch($workDir . '/db.sqlite');
$capsule = new Capsule;
$capsule->addConnection(['driver' => 'sqlite', 'database' => $workDir . '/db.sqlite']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$schema = Capsule::schema();
if (!$schema->hasTable('items')) {
  $schema->create('items', function ($table) {
    $table->increments('id');
    $table->string('name');
    $table->string('secret');
    $table->integer('rank');
    $table->timestamps();
  });
  // every column orders the rows differently: id 1,2,3 | name 3,1,2 | secret 2,3,1 | rank 1,3,2
  Capsule::table('items')->insert([
    ['id' => 1, 'name' => 'b', 'secret' => 'z', 'rank' => 1],
    ['id' => 2, 'name' => 'c', 'secret' => 'x', 'rank' => 3],
    ['id' => 3, 'name' => 'a', 'secret' => 'y', 'rank' => 2],
  ]);
}

// creates elausers table with the default admin (id 1) on first use
if (Eladmin\Auth\EloquentUser\User::count() == 1) {
  // id 2 is deleted by tests, id 3 is a regular user without admin role
  foreach (['victim', 'editor'] as $login) {
    $user = new Eladmin\Auth\EloquentUser\User();
    $user->login = $login;
    $user->passwordhash = $login . 'password';
    $user->role = 'user';
    $user->save();
  }
}

class Item extends Illuminate\Database\Eloquent\Model {
  protected $table = 'items';
}

class Items extends Eladmin\Modules\Eloquent\Crud {

  protected $model = Item::class;

  // sorting by a nonlistable column is allowed when it's the default
  public $defaults = ['sortBy' => 'rank'];

  protected function crudColumns() {
    $columns = parent::crudColumns();
    $columns->secret->hidden();
    $columns->rank->nonlistable();
    return $columns;
  }

  public function actionFail() {
    throw new \RuntimeException('<b>internal</b>');
  }

}

class FixtureAdmin extends Eladmin\Core {

  protected $auth = Eladmin\Auth\EloquentUser\Module::class;
  protected $modules = ['items' => Items::class];

  public function __construct() {
    $this->cache = getenv('ELADMIN_TEST_DIR') . '/cache';
    parent::__construct();
  }

}

(new FixtureAdmin())->run();
