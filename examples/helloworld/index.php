<?php
require_once(__DIR__ . '/../eloquent_models/bootstrap.php');
use Onspli\Eladmin;

class Events extends Eladmin\Modules\Eloquent\Crud {
  protected $model = Examples\Eloquent\Event::class;
  protected function crudColumns() {
    $columns = parent::crudColumns();
    $columns->when->datetime('j.n.Y')->default('2.9.2012')->disabled();
    $columns->created_at->datetime('j.n.Y H:i:s');
    $columns->updated_at->datetime('j.n.Y H:i:s');
    return $columns;
  }
}

class Tickets extends Eladmin\Modules\Eloquent\Crud {
  protected $model = Examples\Eloquent\Ticket::class;

  public $defaults = ['sortBy' => 'name', 'direction' => 'desc'];

  protected function crudColumns() {
    $columns = parent::crudColumns();
    $columns->updated_at->nonlistable();
    $columns->status->select(['new' => 'New', 'confirmed' => 'Confirmed', 'cancelled' => 'Cancelled']);
    return $columns;
  }

  protected function crudActions() {
    $actions = parent::crudActions();
    $actions->cancel->label('Cancel')->bulk()->nonlistable()->filter(function($row) { return $row['status'] != 'cancelled'; });
    $actions->data->done('alert(this.data.msg);');
    return $actions;
  }

  public function actionCancel() {
    if ($this->model()->status == 'cancelled')
      throw new Eladmin\Exception\BadRequestException('Already cancelled.');
    $this->model()->status = 'cancelled';
    $this->model()->save();
    $this->renderText('Cancelled.');
  }

  public function actionData() {
    $this->renderJson(['msg' => 'Ahoj']);
  }
}

class Admin extends Eladmin\Core {

  protected $auth = Eladmin\Auth\EloquentUser\Module::class;

}

$admin = new Admin([Tickets::class, Events::class]);
$admin->run();
