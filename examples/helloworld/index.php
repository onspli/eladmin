<?php
require_once(__DIR__ . '/../eloquent_models/bootstrap.php');
use Onspli\Eladmin;

class Events extends Eladmin\Modules\Eloquent\Crud {
  protected $model = Examples\Eloquent\Event::class;
}

class Tickets extends Eladmin\Modules\Eloquent\Crud {
  protected $model = Examples\Eloquent\Ticket::class;

  protected function crudColumns() {
    $columns = parent::crudColumns();
    $columns->updated_at->nonlistable();
    return $columns;
  }
}

class Admin extends Eladmin\Core {

  protected $auth = Eladmin\Auth\EloquentUser\Module::class;

}

$admin = new Admin([Tickets::class, Events::class]);
$admin->run();
