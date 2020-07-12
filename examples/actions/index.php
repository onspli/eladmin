<?php
require __DIR__.'/../vendor/autoload.php';

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Onspli\Eladmin\Exception;
use Onspli\Eladmin\Eladmin;
use Onspli\Eladmin\Module\Eloquent\Crud;

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

  /**
  * Set the title and icon used in the admin menu.
  */
  protected $elaTitle = 'Events';
  protected $elaIcon = '<i class="fas fa-calendar-alt"></i>';

  /**
  * Roles authorized to work with the Event crud.
  */
  protected $elaAuthorizedRoles = ['admin', 'user'];

  /**
  * Specify authorized roles for different actions.
  */
  protected $elaAuthorizedRolesActions = [
    'update' => ['admin'],          // only 'admin' role can update records
    'delete' => ['admin'],
    'read' => [],                   // all users can do that
    'create' => ['admin', 'user']   // only users with roles 'admin' or 'user' are allowed
  ];

  /**
  * Column used to represent event in relations with other models.
  */
  public $elaRepresentativeColumn = 'name';

  /**
  * Configure appearance and inputs for the table columns.
  */
  public function elaColumns(){
    $columns = $this->elaColumnsDef();

    /**
    * Set label.
    */
    $columns->when->label('When');

    /**
    * Set description to help people fill the input.
    */
    $columns->name->label('Event')->desc('The name of the event.');

    /**
    * Don't show desc column in the table of events.
    * Use textarea for editing the value.
    */
    $columns->description->label('Description')->nonlistable()->textarea();

    /**
    * Move where column just before when column.
    */
    $columns->where->label('Where')->before('when');

    /**
    * Move created column just after where column.
    * Remove created_at from CREATE and EDIT form.
    */
    $columns->created_at->label('Created')->after('where')->noneditable();

    /**
    * Move price column to the end.
    * Change format of displayed value and output it unescaped.
    */
    $columns->price->label('Price')->before()->format(function($val){ return '<em class="text-right d-block">'.$val.' Kč</em>'; })->raw();

    /**
    * Add new column computing the number of attenders.
    * Disable the editation as the value won't save anyway.
    */
    $columns->attenders->label('Attenders')->format(function($val, $row){ return Registration::where('event_id', $row->id)->count(); })->disabled();

    /**
    * Don't show or edit updated_at column.
    */
    unset($columns->updated_at);

    /**
    * Validate or modify data.
    */
    $columns->name
        ->validate(function($val, $row){
          if(!$val)
            throw new Exception\BadRequestException('You have to fill the name!');
        })
        ->set(function($val, $row){
          if($val == 'change') return 'changed';
          return $val;
        });

    return $columns;
  }

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

  /**
  * Set the title and icon used in the admin menu.
  */
  protected $elaTitle = 'Attenders';
  protected $elaIcon = '<i class="fas fa-user-check"></i>';
  public $elaOrderBy = 'name';
  public $elaOrderDirection = 'asc';


  public function elaColumns(){
    $columns = $this->elaColumnsDef();
    $columns->id->enabled();

    $columns->name->label('Name');
    $columns->email->label('E-mail');
    $columns->created_at->label('Registered');

    /**
    * Select input with constant options. Format the output and show it unescaped.
    */
    $columns->status
        ->label('Status')
        ->select(['new'=>'New', 'confirmed'=>'Confirmed', 'cancelled'=>'Cancelled'])
        ->format(function($val){
          switch($val){
            case 'new': return '<span class="badge badge-primary">'.$val.'</span>';
            case 'confirmed': return '<span class="badge badge-success">'.$val.'</span>';
            case 'cancelled': return '<span class="badge badge-danger">'.$val.'</span>';
          }
          return $val;
        })
        ->raw();

    /**
    * Registration belongs to Event relation.
    */
    $columns->event_id->label('Event')->belongsTo(Event::class)->select();

    /**
    * Don't show or edit updated_at column.
    */
    unset($columns->updated_at);

    return $columns;
  }

  /**
  * Define new action 'cancel' which cancels registration.
  */
  public function elaActionCancel(){
    if($this->status == 'cancelled')
      throw new Exception\BadRequestException('Already cancelled!');
    $this->status = 'cancelled';
    $this->save();
    echo 'Registration #'.$this->id.' was cancelled.';
  }

  /**
  * Configure actions.
  */
  public function elaActions(){
    $actions = $this->elaActionsDef();
    $actions->cancel          // method elaActionCancel
      ->label(function($row){return 'Cancel #'.$row->id;}) // label can be string or function
      ->icon('<i class="far fa-times-circle"></i>')
      ->style('warning')      // boostrap button styles
      ->confirm('Do you really want to cancel?')    // confirm the action
      ->done('console.log("Action \'cancel\' done.");')  // run script after the action is done
      ->listable()            // show the action in the table of registrations
      ->editable()           // show the action in the update form
      ->auth('admin');//->auth('admin');
    return $actions;
  }

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

  /**
  * Localize the interface. Supported languages are en_US, cs_CZ.
  */
  protected $lang = 'en_US';

  /**
  * Set the title for the administration.
  */
  protected $title = 'Cool Website';

  /**
  * Set the directory with views, so we can override default appearance and
  * add new components. Eladmin uses Blade template engine.
  */
  protected $views = __DIR__.'/../views';
}

/**
* Run Eladmin
*/
$myEladmin = new MyEladmin();
$myEladmin->run();
