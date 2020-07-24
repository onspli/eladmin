# Under the Hood of Eladmin

The main parts of Eladmin are the core class `Eladmin` and base trait `Module\Module`.

## Eladmin class
The core which generates the admin interface and process requests. The simpliest setup is
```php
class MyEladmin extends Eladmin {
  protected $modules = [ModuleA::class, ModuleB::class];
}
$myeladmin = new MyEladmin();
$myeladmin->run();
```
A module is any class which uses `Module\Module` or some derived trait.

Each module is identified by its `elakey` which is equal to its index in `Eladmin::$modules` array. The `elakey` of Eladmin core is an empty string.

### Requests
```
.
```
Show login page or reditect to first authorized module (if already logged in).

```
?elalogout
```
Logout. Returns `UnathorizedException` if ajax request, or redirect to `.`

```
?elalogin
```
Login. Passing credentials is a scope of authorization module. Redirect to `.` if it isn't ajax request.

```
?elamodule=<elakey>
```
Render webpage with the admin interface of the module.

```
?elamodule=<elakey>&elaasset=<path>
```
Render asset. `path` is relative to `assets` subfoler in module views directory

```
?elamodule=<elakey>&elaaction=<action>&elatoken=<csrftoken>
```
Run an action of the module. Passing values and response format is a scope of the module.

### Configuration
Override these properties to configure Eladmin.
```php
// override to register admin modules
protected $modules = [];

// override to set administration title
protected $title = "Eladmin";

// override to set language
protected $lang = "en_US";

// override to use advanced authorization, set to null to disable authorization completely
protected $auth = Auth\Password::class;

// override to set Blade cache directory
protected $cache = __DIR__ . '/../cache';

// override to extend blade views directory
protected $views = null;

// override to set monolog report level, null disables logging
protected $logLevel = \Monolog\Logger::ERROR;

// override to set monolog log file
protected $logFile = __DIR__ . '/../mono.log';
```

### Public Interface
Public methods:
```php
// Run Eladmin. It's just a wrapper of method runNoCatch catching exceptions.
final public function run() : void

// Run Eladmin. The main function which processes the requests.
final public function runNoCatch() : void

// Return administration title to show it in templates.
public function title() : string

// Get eladmin version
final public function version() : string

// Eladmins elakey - empty string
final public function elakey() : string

// Return requested action key, null if no action requested
final public function actionkey() : ?string

// Return requested module key, null if no module requested
final public function modulekey() : ?string

// Return current CSRF token
final public function CSRFToken() : string

// Create request url
final public function request($module, ?string $action = null, array $args = []) : string

// Create asset url, file path relative to /assets directory. Default $version = time()
final public function asset($module, string $path, ?string $version = null) : string

// Returns username to show it in templates. Returns null if authorization is off.
final public function username() : ?string

// Return authorization instance. Returns null if authorization is off.
final public function user() : ?object

// Returns true if user is authorized to run the action of the module.
final public function auth($module, ?string $action = null) : bool

// Return module instance or null if not authorized. Default $elakey = modulekey()
final public function module(?string $elakey = null) : ?object

// Return instances of all modules user is authorized to work with.
final public function modules() : array

// Return an instance of Blade.
public function blade(array $views = []) : Blade

// Return rendered view. Passes $args and instance of eladmin as $eladmin to the template.
final public function view(string $template, array $args = [], ?Blade $blade = null) : string

// monolog Logger
final public function log() : object
```
Static public interace:
```php
// Check if class is eladmin module.
final static public function isModule($class) : bool

// Check if eladmin was run with ajax request.
final static public function isAjaxRequest() : bool

// Redirect (or exit if ajax request). Default url = homepage
final static public function redirect(string $url = '.') : void

// We want action keys to be case insensitive. Convert action to lowercase.
final static public function normalizeActionName(string $action) : string
```

Actions:
```php
final public function elaActionAccount()
final public function elaActionAccountForm()
```

Private methods and properties:
```php
// modules instances
private $imodules = [];

// authorization instance
private $iauth = null;

// gettext translator
private $t;

// monolog Logger
private $log;

// requested action
private $actionkey = null;

// requested module
private $modulekey = null;

// Extends array of directories of views and assets
private function views(array $views = []) : array

// Return requested asset path, null if no asset requested
private function assetpath() : ?string

private function initLocalization() : void
private function initSessions() : void
private function initCache() : void
private function initAuthorization() : void
private function initAllModules() : void
private function initMonolog() : void
```

## Module trait
Trait's code is simply copied into class which is using it. To minimalise possible conflicts with existing methods and properties, modules should use **ela**-prefix.

Module needs to have access to Eladmin core object and it needs to know its elakey. These properties are initialized by calling `elaInit` method.

```php
// Eladmin core instance
private $eladmin = null;

// Module's elakey
private $elakey = null;

// override to set module's name
// protected $elaTitle = class_basename(static::class);

// override to set module's icon
// protected $elaIcon = '<i class="fas fa-puzzle-piece"></i>';

// override to set authorized roles. empty array means any role
// protected $elaRoles = [];

// override to set authorized roles. empty array means any role.
// It doesn't make sanse to have actions no one can perform.
// format ['read' => [], 'write' => ['admin']]
// protected $elaActionRoles = [];

// normalizing action names for elaActionRoles is expensive, we want to do it only once
private $elaActionNamesNormalized = false;

// Each module has to be initialized with eladmin instance and its own elakey.
final public function elaInit($eladmin, $elakey) : void

// Check if module was initialized.
final public function elaInitCheck() : void

// Each module has its elakey - index in modules array - used to address requests.
final public function elakey() : string

// Check if user is authorized to do action, or athorized to access module at all.
final public function elaAuth(?string $action = null) : bool

// Get name of the module.
public function elaTitle() : string

// Get icon of the module.
public function elaIcon() : string

// Return url for this module.
final public function elaRequest($action = null, $args = []) : string

// Create asset url, file path relative to /assets directory. Default $version = time()
final public function elaAsset(string $path, ?string $version = null) : string

// Get roles authorized to work with the module, or specific action. Empty array means any role is authorized.
final public function elaRoles($action = null) : array

// Set roles authorized to work with the module, or specific action. Empty array means any role is authorized.
final public function elaSetRoles(array $roles, $action = null) : void

// Actions will be called on instance of this module returned by this method. Default is $this.
final public function elaInstanceForAction() : object

// Extends array of directories of views and assets
public function elaViews() : array

// Return Blade instance
public function eleBlade() : Blade

// Return rendered view.
final public function elaView(string $name, array $args = []) : string

// Determinate asset content-type and print it.
public function elaFile($path) : void

```

Convenient output methods:
```php
// Convinient method for plain text output. Sets HTTP header text/plain and echo $str.
final static public function elaOutText(?string $str = null) : void

// Convinient method for html output. Sets HTTP header text/html and echo $str.
final static public function elaOutHtml(?string $str = null) : void

// Convinient method for json output. Sets HTTP header application/json and echo serialized $json.
final static public function elaOutJson(?array $json = null) : void
```
