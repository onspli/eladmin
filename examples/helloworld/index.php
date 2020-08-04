<?php
require_once(__DIR__ . '/../eloquent_models/bootstrap.php');
use Onspli\Eladmin;

class Events extends Eladmin\Modules\Eloquent\Crud {
  protected $model = Examples\Eloquent\Event::class;
  protected function crudColumns() {
    $columns = parent::crudColumns();
    $columns->when->datetime('j.n.Y');
    $columns->created_at->datetime('j.n.Y H:i:s', true);
    $columns->updated_at->datetime('j.n.Y H:i:s', true);
    return $columns;
  }
}

class Tickets extends Eladmin\Modules\Eloquent\Crud {
  protected $model = Examples\Eloquent\Ticket::class;

  protected function crudColumns() {
    $columns = parent::crudColumns();
    $columns->updated_at->nonlistable();
    $columns->status->select(['new' => 'New', 'confirmed' => 'Confirmed', 'cancelled' => 'Cancelled']);
    return $columns;
  }

  protected function crudActions() {
    $actions = parent::crudActions();
    $actions->cancel->label('Cancel')->bulk()->nonlistable()->filter(function($row) { return $row['status'] != 'cancelled'; });
    return $actions;
  }

  public function actionCancel() {
    if ($this->model()->status == 'cancelled')
      throw new Eladmin\Exception\BadRequestException('Already cancelled.');
    $this->model()->status = 'cancelled';
    $this->model()->save();
    $this->renderText('Cancelled.');
  }
}

class Admin extends Eladmin\Core {

  protected $auth = Eladmin\Auth\EloquentUser\Module::class;

}

$admin = new Admin([Tickets::class, Events::class]);
$admin->run();
