# eladmin
Eladmin generates CRUD/admin interface for Eloquent.

## Instalation
You can install Eladmin using composer:
```
composer require onspli/eladmin
```

## Getting started
Let us have a simple website where users can register for events. We have two Eloquent models *Event* and *Registration* and we want to generate the admin interface for them. The steps we have to take are:
1. use *Module\Eloquent\Crud* trait in the models
2. extend Eladmin class with basic configuration properties *$cache* and *$modules*
3. call *Eladmin::run()* method to run Eladmin

Here is an example with a minimal configuration:

```php
<?php

require __DIR__.'/../vendor/autoload.php';

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
  protected $cache = __DIR__.'/../cache';

  /**
  * Add modules to the administration.
  */
  protected $modules = [Registration::class, Event::class];
}

/**
* Run Eladmin
*/
$myEladmin = new MyEladmin();
$myEladmin->run();

```

Eladmin comes with a simple authorization and user management out-of-the-box. Don't worry, the authorization can be easily overriden with your own solution. Default credentials are eladmin/nimdale.

![Login Page](/docs/screenshot/login.png)

Don't forget to change your password after your first login by clicking the Account button in the upper right corner.

![User's Account](/docs/screenshot/account.png)

Here is the interface got with the minimal configuration example above.

![Minimal Configuration](/docs/screenshot/helloworld2.png)

![Edit Entry](/docs/screenshot/editentry2.png)

![Add User](/docs/screenshot/adduser.png)

## Advanced Configuration

An example and screenshots:

```php
<?php

require __DIR__.'/../vendor/autoload.php';

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

  public function elaColumns(){
    $columns = $this->elaColumnsDef();

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
}

/**
* Eladmin configuration
*/
class MyEladmin extends Eladmin
{
  /**
  * Cache directory used by template engine
  */
  protected $cache = __DIR__.'/../cache';

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
```

![Advanced Configuration](/docs/screenshot/columns1.png)

![Advanced Configuration](/docs/screenshot/columns2.png)

![Advanced Configuration](/docs/screenshot/columns3.png)

![Advanced Configuration](/docs/screenshot/columns4.png)

## Actions 

There are four default actions we can do with the records: *create*, *read*, *update*, *delete*. If we use soft deletes in our model there are two additional actions *restore* and *forceDelete*. Sometimes it's not enough and we want to define our own actions. Eladmin can do that.

We want do add action *cancel* which cancels a registration. Add folowing code to the *Registration* model:
```php 
  /**
  * Define new action 'cancel' which cancels registration.
  */
  public function elaActionCancel(){
    $id = $_POST['id']??0;
    $row = $this->find($id);
    if(!$row)
      throw new Exception\BadRequestException('Registration does not exist!');
    if($row->status == 'cancelled')
      throw new Exception\BadRequestException('Already cancelled!');
    $row->status = 'cancelled';
    $row->save();
    echo 'Registration #'.$id.' was cancelled.';
  }

  /**
  * Configure actions.
  */
  public function elaActions(){
    $actions = $this->elaActionsDef();
    $actions->cancel          // method elaActionCancel
      ->label('Cancel')
      ->icon('<i class="far fa-times-circle"></i>')
      ->style('warning')      // boostrap button styles
      ->listable()            // show the action in the table of registrations
      ->editable();           // show the action in the update form
    return $actions;
  }
```

Result:

![Action Cancel](/docs/screenshot/actions.png)

# Authorization 
Eladmin provides a way to authorize users to do actions. The following code in *Event* module does the authorization:

```php 
  /**
  * Roles authorized to work with the Event crud.
  */
  protected $elaAuthorizedRoles = ['admin', 'user'];

  /**
  * Authorized roles for specific actions.
  */
  protected $elaAuthorizedRolesActions = [
    'update' => ['admin'],          // only 'admin' role can update records
    'delete' => ['admin'],
    'read' => [],                   // all users can do that
    'create' => ['admin', 'user']   // only users with roles 'admin' or 'user' are allowed
  ];
```

It results in the following (user *onspli* has role *user*).

![Authorization](/docs/screenshot/authorization.png)

By default only 'admin' role is granted to work with eladmin *Users* crud.

## Data Validation and Modification

Method *elaModifyPost* is invoked by actions *create* and *update*. By overriding the method you can do the validation or modification of the data. Example code in *Event* model:

```php 
  /**
  * Validate or modify data.
  */
  protected function elaModifyPost(){
    $name = $_POST['name']??'';
    /**
    * Validate data.
    */
    if(!$name)
      throw new Exception\BadRequestException('You have to fill the name!');

    /**
    * Modify data.
    */
    $_POST['name'] = 'Event: '.$name;
  }
```

