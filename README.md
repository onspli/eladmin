# eladmin
Eladmin generates CRUD/admin interface for Eloquent.

## Getting started
Let us have a simple website where users can register for events. We have two Eloquent models Event and Registration and we want to generate the admin interface for them. The steps we have to take are:
1. use Module\Eloquent\Crud trait in the models
2. extend Eladmin class with basic configuration properties $cache and $modules
3. call Eladmin::run() method to run Eladmin

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
