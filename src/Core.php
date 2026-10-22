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
* asset cache expiration in secs
*/
protected $assetCacheExpiration = 2592000;

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
* keys of modules the user is not authorized to work with
*/
private $unauthorizedModules = [];

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
  // Respect the @ operator. Since PHP 8, error_reporting() is no longer 0 inside @,
  // it is masked to fatal errors only, so test the error level against it.
  if (!(error_reporting() & $errno)) {
    return false;
  }
  throw new \ErrorException($errstr, $errno, 0, $errfile, $errline);
}

/**
* Run Eladmin. It's just a wrapper of method runNoCatch catching exceptions.
*/
final public function run() : void {
  set_error_handler(array(self::class, 'errorHandler'), E_ALL & ~(E_DEPRECATED | E_USER_DEPRECATED));
  try {
    $this->runNoCatch();
  } catch(Exception\UnauthorizedException $e) {
    if ($this->iauth !== null && !$e instanceof Exception\CSRFException) {
      $this->iauth->logout();
      $this->renewSession();
    }
    if (!static::isAjaxRequest())
      $this->redirect();
    static::errorHeaders("HTTP/1.1 401 Unauthorized");
    echo $e->getMessage();
  } catch(Exception\BadRequestException $e) {
    static::errorHeaders("HTTP/1.1 400 Bad Request");
    echo $e->getMessage();
  } catch(Exception\Exception $e) {
    static::errorHeaders("HTTP/1.1 500 Internal Server Error");
    echo $e->getMessage();
  } catch (\Throwable $e) {
    // messages of non-eladmin exceptions are not meant to contain HTML and may contain user input
    static::errorHeaders("HTTP/1.1 500 Internal Server Error");
    echo static::escape($e->getMessage());
  }
}

/**
* Send status line and headers of an error response.
*/
static private function errorHeaders(string $status) : void {
  if (headers_sent())
    return;
  header($status);
  header('X-Content-Type-Options: nosniff');
}

/**
* Escape string to be safely included in HTML.
*/
static private function escape(?string $str) : string {
  return htmlspecialchars($str ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
* Run Eladmin. The main function which processes the requests.
*/
final public function runNoCatch() : void {

  // Cache action key and modulekey. We don't want them accidentaly changed.
  $this->actionkey();
  $this->modulekey();

  if (isset($_GET['elaasset'])) {
    // Assets of the core are public, the login page needs them. Assets of modules require authorization.
    if ($this->modulekey() !== '') {
      $this->initSessions(true);
      $this->initAuthorization();
    }
    $asset = $this->assetpath();
    $this->module()->renderAsset($asset);
    return;
  }

  $this->initLocalization();
  $this->initSessions();
  $this->initAuthorization();

  // Authentication and authorization.
  if ($this->auth !== null) {
    // Logout and login don't use CSRF tokens, reject them when they come from another site.
    $isLogout = isset($_GET['elalogout']) && !static::isCrossSiteRequest();
    if ($isLogout) {
      throw new Exception\UnauthorizedException();
    }

    $isLogin = isset($_GET['elalogin']);
    if ($isLogin) {
      if (static::isCrossSiteRequest())
        throw new Exception\BadRequestException(__('Cross-site login request rejected.'));
      $this->iauth->login($_POST);
    }

    $isAuthorized = $this->iauth->authorize();
    if ($isLogin) {
      if (!$isAuthorized) {
        throw new Exception\UnauthorizedException(__("Wrong credentials!"));
      } else {
        // prevent session fixation, new session id and CSRF token after login
        $this->renewSession();
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
    // module() is null when user is not authorized to work with the module
    if($this->module() === null || $this->module() == $this)
      self::redirect();
    else
      echo $this->module()->render('modules.core.module');
    return;
  }

  // CSRF token comparsion
  $this->CSRFAuth();
  // Check if user is authorized to do the action.
  if ($this->module() === null || !$this->module()->auth($this->actionkey())) {
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
    throw new Exception\BadRequestException('Class ' . $classname . ' does not have method ' . static::escape($method) . '!');
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
  // illuminate/view resolves the blade compiler from the global container instance,
  // so the container used by Blade has to be registered as the global one.
  $container = new \Jenssegers\Blade\Container();
  \Illuminate\Container\Container::setInstance($container);
  return new Blade($views, $this->cache, $container);
}

/**
* Get eladmin version.
*/
final public function version() : string {
  return "v0.4.0";
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
  if (!is_string($token) || !$token) {
    $token = bin2hex(random_bytes(32));
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
  if (!is_string($path) || strpos($path, '..') !== false || strpos($path, "\0") !== false)
    throw new Exception\UnauthorizedException('Asset filename cannot contain ".." due security issues.');

  $module = $this->module();
  if ($module === null)
    throw new Exception\UnauthorizedException('Not authorized to access asset ' . static::escape($path) . ' for module "' . static::escape($this->modulekey()) . '".');

  $dirs = $module->views();
  foreach ($dirs as $dir) {
    $file = $dir . '/assets/' . $path;
    if (file_exists($file))
      return $file;
  }
  throw new Exception\BadRequestException('Asset ' . static::escape($path) . ' not found  for module "' . static::escape($module->elakey()) . '".');
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
    throw new Exception\UnauthorizedException('Asset extension ' . static::escape($extension) . ' not allowed.');

  @$content = file_get_contents($path);
  if ($content === false)
    throw new Exception\Exception('Could not read asset ' . static::escape($path) . '.');
  header('Content-type:' . $contentType);
  header('Cache-Control: max-age=' . intval($this->assetCacheExpiration));
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
  if (isset($this->unauthorizedModules[$elakey]))
    return null;
  // has the module been initialized?
  if (!isset($this->imodules[$elakey])) {
    $moduleclass = $this->modules[$elakey] ?? null;
    if ($moduleclass === null)
      throw new Exception\BadRequestException('Unknown module "' . static::escape($elakey) . '"!');
    if (!is_subclass_of($moduleclass, Module::class))
      throw new Exception\Exception('Class ' . $moduleclass . ' is not Eladmin module.');

    $imodule = new $moduleclass($this, $elakey);
    $roles = $imodule->roles();
    if ($this->iauth && ($roles === IAuth::NOONE || !$this->iauth->authorize($roles))) {
      unset($this->modules[$elakey]);
      $this->unauthorizedModules[$elakey] = true;
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
* Check if the browser reports the request was initiated by another site (Fetch Metadata).
*/
static private function isCrossSiteRequest() : bool {
  return strtolower($_SERVER['HTTP_SEC_FETCH_SITE'] ?? '') === 'cross-site';
}

/**
* Check if eladmin was requested over HTTPS.
*/
static private function isHttps() : bool {
  return !empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off';
}

/**
* Regenerate session id and CSRF token. Called on login and logout.
*/
private function renewSession() : void {
  if (session_status() !== PHP_SESSION_ACTIVE)
    return;
  unset($_SESSION['elacsrftoken']);
  if (!headers_sent())
    session_regenerate_id(true);
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
  $token = $_GET['elatoken'] ?? null;
  if (!is_string($token) || !hash_equals($this->CSRFToken(), $token)) {
    throw new Exception\CSRFException();
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

/**
* Start session unless the application already started it. $readOnly closes the session right away
* and doesn't send cache headers (used for assets).
*/
private function initSessions(bool $readOnly = false) : void {
  $this->log->debug('init sessions');
  if (session_status() === PHP_SESSION_ACTIVE)
    return;
  // Not using strict mode on purpose - a request still carrying the old session id after login
  // (e.g. favicon routed to index.php) would get a new empty session and log the user out.
  // Session fixation is prevented by regenerating session id on login.
  $options = [
    'cookie_httponly' => 1,
  ];
  if (ini_get('session.cookie_samesite') === '')
    $options['cookie_samesite'] = 'Lax';
  if (static::isHttps())
    $options['cookie_secure'] = 1;
  if ($readOnly) {
    $options['read_and_close'] = true;
    $options['cache_limiter'] = '';
  }
  session_start($options);
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
