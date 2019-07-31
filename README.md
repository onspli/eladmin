# eladmin
Eladmin generates CRUD/admin interface for Eloquent.

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

![Login Page](/docs/screenshot/login.png)
![Minimal Configuration](/docs/screenshot/helloworld2.png)
![User's Account](/docs/screenshot/account.png)
![Add User](/docs/screenshot/adduser.png)
![Edit Entry](/docs/screenshot/editentry2.png)
