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
    protected $elaIcon = '<i class="fas fa-clipboard"></i>';

    protected $appends = ['ahoj'];

    public function getAhojAttribute(){
      return 'Ahoj!';
    }

    /**
    * TODO: udělat z column třídu a pracovat s tím nějak takhle
    * $columns['tabornik']->label('Táborník')->desc('Něco')->raw()->escaped()->disabled()->editable()->nonlistable()->input('textarea')->format(function(){return $this.'blabla'});
    */
    public function elaColumns(){
      $columns = parent::elaColumns();
      $columns['tabornik']->label = "Táborník";
      $columns['tabornik']->desc = 'Ten, kdo <strong>pojede</strong> na tábor.';
      $columns['poznamka']->rawoutput = true;
      $columns = $this->elaPutColumnAfter($columns, 'tabornik', 'id');
      $columns['novy'] = new \StdClass;
      $columns['novy']->nonlistable = true;
      return $columns;
    }

    public function elaActions(){
      $actions = parent::elaActions();
      $actions['hello'] = new \StdClass;
      $actions['hello']->label = 'Řekni ahoj';
      $actions['hello']->icon = '<i class="fas fa-key"></i>';
      $actions['hello']->style = 'danger';
      $actions['helo'] = new \StdClass;
      return $actions;
    }

    public function elaActionHello(){
      Header('Content-type: text/plain');
      echo('<b>hello</b>');
    }

    public function elaActionDelRow(){
      parent::elaActionDelRow();
      Header('Content-type: text/plain');
      echo "Smazáno!";
    }


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
    protected $elaAuthorizedRolesForLowercaseActions = [
      'postrow' => ['admin'],
      'delrow'=>['admin'],
      'putrow'=>['n']
    ];

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
