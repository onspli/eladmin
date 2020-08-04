<?php

namespace Onspli\Eladmin;

use \Jenssegers\Blade\Blade;

/**
* Eladmin core class.
*/
class Core extends Module {

/**
* Auth module elakey
*/
const AUTH_ELAKEY = 'elaauth';

/**
* override to register admin modules
*/
protected $modules = [];

/**
* override to set administration title
*/
protected $title = "Eladmin";

/**
* override to set language
*/
protected $lang = "en_US";

/**
* override to use advanced authorization, set to null to disable authorization completely
*/
protected $auth = Auth\Password::class;

/**
* override to set Blade cache directory
*/
protected $cache = __DIR__ . '/../cache';

/**
* override to extend blade views directory
*/
protected $views = null;

/**
* override to set monolog report level, null disables logging
*/
protected $logLevel = null;

/**
* override to set monolog log file
*/
protected $logFile = __DIR__ . '/../mono.log';

/**
* modules instances
*/
private $imodules = [];

/**
* authorization instance
*/
private $iauth = null;

/**
* gettext translator
*/
private $t;

/**
* monolog Logger
*/
private $log;

/**
* requested action key
*/
private $actionkey = null;

/**
* requested module elakey
*/
private $modulekey = null;

public function __construct(?array $modules = null) {
  if ($modules !== null) {
    $this->modules = $modules;
  }
  $this->initMonolog();
  $this->log->info('Construct eladmin.', $_GET);
  if (is_subclass_of($this->auth, Module::class)) {
    $this->modules[static::AUTH_ELAKEY] = $this->auth;
  }
  parent::__construct($this, '');
}


final static public function errorHandler($errno, $errstr, $errfile, $errline) {
  // error_reporting() will return 0 when the call that triggered the error was preceded by an @.
  if (error_reporting() == 0) {
    return;
  }
  throw new \ErrorException($errstr, $errno, 0, $errfile, $errline);
}

/**
* Run Eladmin. It's just a wrapper of method runNoCatch catching exceptions.
*/
final public function run() : void {
  set_error_handler(array(self::class, 'errorHandler'), (E_ALL | E_STRICT) &  ~(E_DEPRECATED | E_USER_DEPRECATED));
  try {
    $this->runNoCatch();
  } catch(Exception\UnauthorizedException $e) {
    if ($this->auth !== null)
      $this->iauth->logout();
    if (!static::isAjaxRequest())
      $this->redirect();
    header("HTTP/1.1 401 Unauthorized");
    echo $e->getMessage();
  } catch(Exception\BadRequestException $e) {
    header("HTTP/1.1 400 Bad Request");
    echo $e->getMessage();
  } catch(Exception\Exception $e) {
    header("HTTP/1.1 500 Internal Server Error");
    echo $e->getMessage();
  } catch (\Throwable $e) {
    header("HTTP/1.1 500 Internal Server Error");
    echo $e->getMessage();
  } catch(\Exception $e) {
    header("HTTP/1.1 500 Internal Server Error");
    echo $e->getMessage();
  }
}

/**
* Run Eladmin. The main function which processes the requests.
*/
final public function runNoCatch() : void {

  // Cache action key and modulekey. We don't want them accidentaly changed.
  $this->actionkey();
  $this->modulekey();

  $asset = $this->assetpath();
  if ($asset !== null) {
    $this->module()->renderAsset($asset);
    return;
  }

  $this->initLocalization();
  $this->initSessions();
  $this->initAuthorization();

  // Authentication and authorization.
  if ($this->auth !== null) {
    $isLogout = isset($_GET['elalogout']);
    if ($isLogout) {
      throw new Exception\UnauthorizedException();
    }

    $isLogin = isset($_GET['elalogin']);
    if ($isLogin) {
      $this->iauth->login($_POST);
    }

    $isAuthorized = $this->iauth->authorize();
    if ($isLogin) {
      if (!$isAuthorized) {
        throw new Exception\UnauthorizedException(__("Wrong credentials!"));
      } else {
        // check if user is authorized to work with eladmin
        if (!$this->auth())
          throw new Exception\UnauthorizedException(__('Not authorized to run Eladmin.'));
        // check if user is authorized to work with any module
        $this->firstAuthorizedModuleKey();
        self::redirect();
      }
      return;
    }

    $loginFields = $this->iauth->loginFields();
    if (!$isAuthorized) {
      if ($this->isAjaxRequest())
        throw new Exception\UnauthorizedException();
      if ($loginFields === null) {
        $this->iauth->unauthorized();
        throw new Exception\UnauthorizedException();
      } else {
        if ($this->modulekey() !== null)
          $this->redirect();
        echo $this->render('modules.core.login', ['loginFields' => $loginFields]);
        return;
      }
    }
    // it is not an attempt to login and user is authorized to continue execution

    // check if user is authorized to work with eladmin
    if (!$this->auth())
      throw new Exception\UnauthorizedException(__('Not authorized to run Eladmin.'));
  }

  // No action, render module view.
  if ($this->actionkey() === null) {
    $this->initAllModules();
    if ($this->modulekey() === null) {
      $url = $this->module($this->firstAuthorizedModuleKey())->requestUrl();
      $this->redirect($url);
      return;
    }
    if($this->module() == $this)
      self::redirect();
    else
      echo $this->module()->render('modules.core.module');
    return;
  }

  // CSRF token comparsion
  $this->CSRFAuth();
  // Check if user is authorized to do the action.
  if (!$this->module()->auth($this->actionkey())) {
    throw new Exception\UnauthorizedException();
  }

  $elakey = $this->module()->elakey();
  if ($elakey == $this->elakey())
    $classname = static::class;
  else
    $classname = $this->modules[$elakey];

  $method = self::ACTION_PREFIX . ucfirst($this->actionkey());

  // Check if action exists.
  if (!is_callable([$this->module(), $method]) || !$this->module()->hasAction($this->actionkey())) {
    throw new Exception\BadRequestException('Class ' . $classname . ' does not have method ' . $method . '!');
  }
  $this->module()->prepare();
  call_user_func([$this->module(), $method]);
}

/**
* Return administration title to show it in templates.
*/
public function title() : string {
  return $this->title;
}

/**
* Return Blade instance
*/
public function blade() : Blade {
  $this->initCache();
  if ($this->modulekey() !== null) {
    $views = $this->module()->views();
  } else {
    $views = $this->views();
  }
  return new Blade($views, $this->cache);
}

/**
* Get eladmin version.
*/
final public function version() : string {
  return "v0.3.0";
}

/**
* Return authorization instance.
*/
final public function iauth() : ?IAuth {
  return $this->iauth;
}

/**
* Return requested action key, null if no action requested
*/
final public function actionkey() : ?string {
  if ($this->actionkey !== null)
    return $this->actionkey;
  if (isset($_GET['elaaction']))
    $this->actionkey = $this->parseAction($_GET['elaaction']);
  return $this->actionkey;
}

/**
* Return requested module key, null if no module requested
*/
final public function modulekey() : ?string {
  if ($this->modulekey !== null)
    return $this->modulekey;
  $this->modulekey = $_GET['elamodule'] ?? null;
  return $this->modulekey;
}

/**
* Generate CSRF token
*/
final public function CSRFToken() : string {
  $token = $_SESSION['elacsrftoken'] ?? null;
  if (!$token) {
    $token = '';
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for ($i = 0; $i < 16; $i++) {
      $token .= substr($chars, rand(0, strlen($chars) - 1), 1);
    }
    $_SESSION['elacsrftoken'] = $token;
  }
  return $token;
}

/**
* Return requested asset path, null if no asset requested
*/
private function assetpath() : ?string {
  $path = $_GET['elaasset'] ?? null;
  if ($path === null)
    return null;
  if (strpos($path, '..') !== false)
    throw new Exception\UnauthorizedException('Asset filename ' . $path . ' cannot contain ".." due security issues.');

  $module = $this->module();
  if ($module === null)
    throw new Exception\UnauthorizedException('Not authorized to access asset ' . $path . ' for module "' . $this->modulekey() . '".');

  $dirs = $module->views();
  foreach ($dirs as $dir) {
    $file = $dir . '/assets/' . $path;
    if (file_exists($file))
      return $file;
  }
  throw new Exception\BadRequestException('Asset ' . $path . ' not found  for module "' . $module->elakey() . '".');
}

/**
* Determinate asset content-type and render it.
*/
public function renderAsset(string $path) : void {
  $path_parts = pathinfo($path);
  $extension = $path_parts['extension'];
  $assetContentTypes = [
    'css' => 'text/css',
    'js' => 'text/javascript'
  ];
  $contentType = $assetContentTypes[$extension] ?? null;
  if (!$contentType)
    throw new Exception\UnauthorizedException('Asset extension ' . $extension . ' not allowed.');

  @$content = file_get_contents($path);
  if ($content === false)
    throw new Exception\Exception('Could not read asset ' . $path . '.');
  header('Content-type:' . $contentType);
  echo $content;
}

/**
* Return module instance or null if not authorized. Default $key = modulekey()
*/
final public function module(?string $elakey = null) : ?Module {
  $elakey = $elakey ?? $this->modulekey();
  if ($elakey === null)
    throw new Exception\BadRequestException('No module requested!');
  if ($elakey === '')
    return $this;
  // has the module been initialized?
  if (!isset($this->imodules[$elakey])) {
    $moduleclass = $this->modules[$elakey] ?? null;
    if ($moduleclass === null)
      throw new Exception\BadRequestException('Unknown module "' . $elakey . '"!');
    if (!is_subclass_of($moduleclass, Module::class))
      throw new Exception\Exception('Class ' . $moduleclass . ' is not Eladmin module.');

    $imodule = new $moduleclass($this, $elakey);
    $roles = $imodule->roles();
    if ($this->iauth && ($roles === IAuth::NOONE || !$this->iauth->authorize($roles))) {
      unset($this->modules[$elakey]);
      return null;
    }
    $this->imodules[$elakey] = $imodule;
  }
  return $this->imodules[$elakey];
}

/**
* Return instances of all authorized modules.
*/
final public function modules() : array {
  $this->initAllModules();
  return $this->imodules;
}

/**
* return first authorized module key
*/
private function firstAuthorizedModuleKey() : string {
  $this->initAllModules();
  foreach ($this->modules as $elakey => $mod)
    return $elakey;
  if ($this->auth !== null)
    $this->iauth->logout();
  throw new Exception\UnauthorizedException(__("You are not authorized to access any module!"));
}

final public function views() : array {
  $views = [];
  if (is_string($this->views)) {
    $views[] = $this->views;
  }
  $views[] = __DIR__ . '/../views';
  return $views;
}

/**
* Check if eladmin was run with ajax request.
*/
static private function isAjaxRequest() : bool {
  return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

/**
* Redirect (or exit if ajax request). Default url = home
*/
static private function redirect(string $url = '.') : void {
  if (!static::isAjaxRequest())
    header('Location: '.$url);
  exit;
}

/**
* Check if CSRF token is valid
*/
private function CSRFAuth() : void {
  if ( ($_GET['elatoken'] ?? null) !== $this->CSRFToken()) {
    throw new Exception\UnauthorizedException(__("CSRF token not valid! Try reloading page."));
  }
}

/**
* Returns username to show it in templates. Returns null if authorization is off.
*/
final public function username() : ?string {
  return $this->iauth ? $this->iauth->userName() : null;
}

final public function accountFields() : ?array {
  return $this->iauth ? $this->iauth->accountFields() : null;
}

final public function actionAccountUpdate() {
  $this->iauth->accountUpdate($_POST);
}

final public function actionAccountForm() {
  echo $this->render('modules.core.accountForm');
}

/**
* monolog Logger
*/
final public function log() : \Monolog\Logger {
  return $this->log;
}

private function initLocalization() : void {
  $this->log->debug('init localization');
  try
  {
    $this->t = new \Gettext\Translator();
    $translations = \Gettext\Translations::fromPoFile(__DIR__.'/../locale/'.$this->lang.'/LC_MESSAGES/messages.po');
    $this->t->loadTranslations($translations);
    $this->t->register();
  }
  catch(\Exception $e)
  {
    throw new \Exception('Locale "'.$this->lang.'" is not supported.');
  }
}

private function initSessions() : void {
  $this->log->debug('init sessions');
  if(!session_id())
  {
    session_start();
  }
}

private function initCache() : void {
  $this->log->debug('init cache');
  if(!$this->cache)
    throw new Exception\Exception('Set '.static::class.'::$cache property to a path to some writeable directory.');
  if (!file_exists($this->cache)) {
    @$result = mkdir($this->cache);
    if (!$result)
      throw new Exception\Exception('Cannot create Blade cache directory '.$this->cache.'.');
  }
  if (!is_writeable($this->cache))
    throw new Exception\Exception('Cannot write to Blade cache directory '.$this->cache.'.');
}

private function initAuthorization() : void {
  if ($this->auth) {
    if (!is_subclass_of($this->auth, IAuth::class))
      throw new Exception\Exception(__('Authorization class %s does not implement IAuth interface.', $this->auth));
    $this->log->debug('init authorization');
    if (is_subclass_of($this->auth, Module::class)) {
      $this->iauth = new $this->auth($this, static::AUTH_ELAKEY);
    } else {
      $this->iauth = new $this->auth();
    }
  }
}

private $allModulesInitialized = false;
private function initAllModules() : void {
  if ($this->allModulesInitialized)
    return;
  $this->log->debug('init all modules');
  foreach ($this->modules as $key => $module) {
    $this->module($key);
  }
  $allModulesInitialized = true;
}

private function initMonolog() : void {
  $this->log = new \Monolog\Logger('log');
  if ($this->logLevel !== null && is_writeable(dirname($this->logFile))) {
    $this->log->pushHandler(new \Monolog\Handler\StreamHandler($this->logFile, $this->logLevel));
  }
}



}
