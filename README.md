# eladmin
A small PHP library that generates a CRUD admin interface. It was built for Eloquent models, but other data sources can be plugged in by extending the generic CRUD module. Docs: [onspli.github.io/eladmin](https://onspli.github.io/eladmin/).

## Usage
```
composer require onspli/eladmin
```

Define modules, register them in a `Core` subclass and run it from your admin entry point:

```php
use Onspli\Eladmin;

class Events extends Eladmin\Modules\Eloquent\Crud {
  protected $model = Event::class; // any Eloquent model
}

class Admin extends Eladmin\Core {
  protected $title = 'My admin';
  protected $modules = [Events::class];
}

(new Admin())->run();
```

Eloquent has to be booted before (e.g. with `Illuminate\Database\Capsule\Manager`), see [examples/](examples/).

By default a single user `eladmin` / `nimdale` is used (`Auth\Password`) - change the password after the first login. For multiple users with roles set `protected $auth = Eladmin\Auth\EloquentUser\Module::class;`.

## Development
Requires PHP 8.1+ with `pdo_sqlite`.
```
composer install
composer test                  # all tests
composer test:unit             # unit tests only
composer test:integration      # integration tests only
vendor/bin/phpunit --filter CSRFTest
```
Integration tests serve the app in `tests/integration/fixture` with PHP built-in server and talk to it over HTTP. `tests/e2e` contains manual browser tests driven by `consecutive.js`, they are not run by PHPUnit.

To try it in a browser: `php -S localhost:8000 -t examples/helloworld`.

API docs in `docs/` are generated from docblocks by [Doctum](https://github.com/code-lts/doctum) with the theme in `docs-theme/`:
```
composer docs:install   # downloads doctum.phar (once)
composer docs:build     # regenerates docs/
```

## Contact
ondrej.splichal@gmail.com
