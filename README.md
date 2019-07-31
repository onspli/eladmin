# eladmin
Eladmin generates CRUD/admin interface for Eloquent.

## Getting started
Let us have simple website where users can register for event. We have two Eloquent models Event and Registration and we want to generate admin interface for them. The steps we have to do are:
1. use Module\Eloquent\Crud trait in the models
2. extends Eladmin class with basic configuration properties $cache and $modules
3. call Eladmin::run() method to run Eladmin

Here is an example with the minimal configuration:
```php
<?php

require __DIR__.'/../vendor/autoload.php';

use Illuminate\Database\Eloquent\Model;
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

Eladmin comes with simple authorization and user management out-of-the-box. Don't worry, the authorization can be easily overriden with your own solutin. Default credentials are eladmin/nimdale.
![Login Page](/docs/screenshot/login.png)

Don't forget to change your password after your first login by clicking the Account button in the upper right corner.
![User's Account](/docs/screenshot/account.png)

Here is the interface got with the minimal configuration example above.
![Minimal Configuration](/docs/screenshot/helloworld2.png)
![Edit Entry](/docs/screenshot/editentry2.png)
![Add User](/docs/screenshot/adduser.png)
