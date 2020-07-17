<?php

namespace Onspli\Eladmin;

class Eladmin {

// Eladmin core is itself a module
use Module;

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
protected $logLevel = \Monolog\Logger::DEBUG;

// override to set monolog log file
protected $logFile = __DIR__ . '/../mono.log';

// modules instances
private $imodules = [];

// authorization instance
private $iauth = null;

// blade template engine instance
private $blade = null;

// gettext translator
private $t;

// monolog Logger
private $log;

// requested action
private $actionkey = null;

// requested module
private $modulekey = null;

// TODO: change concept of testing?
public $consecutive = false;

// Initialize Eladmin.
final public function __construct() {
  $this->initMonolog();
  $this->log->info('Construct eladmin.', $_GET);

  // Cache action key and modulekey. We don't want them accidentaly changed.
  $this->actionkey();
  $this->modulekey();

  $this->elaInit($this, $this->elakey());
}

// Run Eladmin. It's just a wrapper of method runNoCatch catching exceptions.
final public function run() : void {
  try {
    $this->runNoCatch();
  } catch(Exception\UnauthorizedException $e) {
    if ($this->auth !== null)
      $this->iauth->elaLogout();
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
  } catch(\Exception $e) {
    header("HTTP/1.1 500 Internal Server Error");
    echo $e->getMessage();
  }
}

// Run Eladmin. The main function which processes the requests.
final public function runNoCatch() : void {
  $this->prerun();

  $asset = $this->assetpath();
  if ($asset !== null) {
    $this->renderAsset($asset);
    return;
  }

  $testinit = $_GET['elatestinit'] ?? null;
  if ($testinit) {
    $this->testinit();
    return;
  }

  $this->initLocalization();
  $this->initSessions();
  $this->initBladeTemplates();
  $this->initAuthorization();

  // Authentication and authorization.
  if ($this->auth !== null) {
    $isLogout = isset($_GET['elalogout']);
    if ($isLogout) {
      throw new Exception\UnauthorizedException();
    }

    $isLogin = isset($_GET['elalogin']);
    if ($isLogin) {
      $this->iauth->elaLogin();
    }

    $isAuthorized = $this->iauth->elaAuthorize();
    if ($isLogin) {
      if (!$isAuthorized) {
        throw new Exception\UnauthorizedException(__("Wrong credentials!"));
      } else {
        // check if user is authorized to work with eladmin
        if (!$this->elaAuth())
          throw new Exception\UnauthorizedException(__('Not authorized to run Eladmin.'));
        // check if user is authorized to work with any module
        $this->firstAuthorizedModuleKey();
        $this->redirect();
      }
      return;
    }

    $loginFields = $this->iauth->elaLoginFields();
    if (!$isAuthorized) {
      if ($this->isAjaxRequest())
        throw new Exception\UnauthorizedException();
      if ($loginFields === null) {
        $this->iauth->elaUnauthorized();
        throw new Exception\UnauthorizedException();
      } else {
        if ($this->modulekey() !== null)
          $this->redirect();
        echo $this->view('login', ['loginFields' => $loginFields]);
        return;
      }
    }
    // it is not an attempt to login and user is authorized to continue execution

    // check if user is authorized to work with eladmin
    if (!$this->elaAuth())
      throw new Exception\UnauthorizedException(__('Not authorized to run Eladmin.'));
  }

  // No action, render module view.
  if ($this->actionkey() === null) {
    $this->initAllModules();
    if ($this->modulekey() === null) {
      $url = $this->request($this->firstAuthorizedModuleKey());
      $this->redirect($url);
      return;
    }
    if($this->module() == $this)
      echo $this->view('hello');
    else
      echo $this->view('module', ['module'=>$this->module()]);
    return;
  }

  // CSRF token comparsion
  $this->CSRFAuth();
  // Check if user is authorized to do the action.
  if (!$this->module()->elaAuth($this->actionkey()))
    throw new Exception\UnauthorizedException();

  $elakey = $this->module()->elakey();
  if ($elakey == $this->elakey())
    $classname = static::class;
  else
    $classname = $this->modules[$elakey];

  $instanceForAction = $this->module()->elaGetInstanceForAction();
  $instanceForAction->elaInitCheck();
  if (!($instanceForAction instanceof $classname))
    throw new Exception\Exception('Instance for action is instance of class ' . $classname . '!');

  $method = 'elaAction' . ucfirst($this->actionkey());

  // Check if action exists.
  if (!is_callable([$instanceForAction, $method]))
    throw new Exception\BadRequestException('Class ' . $classname . ' does not have method ' . $method . '!');
  call_user_func([$instanceForAction, $method]);
}

// Return administration title to show it in templates.
final public function title() : string {
  return $this->title;
}

// Get eladmin version.
final public function version() : string {
  return "v0.2.2-alpha";
}

// Returns username to show it in templates. Returns null if authorization is off.
final public function username() : ?string {
  return $this->iauth ? $this->iauth->elaUserName() : null;
}

// Return authorization instance.
final public function user() : ?object {
  return $this->iauth;
}

// Eladmins elakey - empty string
final public function elakey() : string {
  return '';
}

// Return requested action key, null if no action requested
final public function actionkey() : ?string {
  if ($this->actionkey !== null)
    return $this->actionkey;
  if (isset($_GET['elaaction']))
    $this->actionkey = static::normalizeActionName($_GET['elaaction']);
  return $this->actionkey;
}

// Return requested module key, null if no module requested
final public function modulekey() : ?string {
  if ($this->modulekey !== null)
    return $this->modulekey;
  $this->modulekey = $_GET['elamodule'] ?? null;
  return $this->modulekey;
}

// Generate CSRF token
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

// Create request url.
final public function request($module, ?string $action = null, array $args = []) : string {
  $data = $args;
  $data['elamodule'] = static::moduleToElakey($module);
  if ($action !== null) {
    $data['elaaction'] = $action;
    $data['elatoken'] = $this->CSRFToken();
  }
  return '?' . http_build_query($data);
}

// Create asset url, file path relative to /assets directory. Default $version = time()
final public function asset(string $path, ?string $version = null) : string {
  $data['elaasset'] = $path;
  $data['ver'] = $version ?? time();
  return '?' . http_build_query($data);
}

// Return requested asset path, null if no asset requested
final private function assetpath() : ?string {
  return $_GET['elaasset'] ?? null;
}

// Return module instance or null if not authorized. Default $key = modulekey()
final public function module(?string $elakey = null) : ?object {
  $elakey = $elakey ?? $this->modulekey();
  if ($elakey === null)
    throw new Exception\BadRequestException(__('No module requested!'));
  if ($elakey === '')
    return $this;
  // has the module been initialized?
  if (!isset($this->imodules[$elakey])) {
    $moduleclass = $this->modules[$elakey] ?? null;
    if ($moduleclass === null)
      throw new Exception\BadRequestException(__('Unknown module "%s"!', $elakey));
    if (!static::isModule($moduleclass))
      throw new Exception\Exception('Class ' . $moduleclass . ' is not Eladmin module.');

    $imodule = new $moduleclass();
    if ($this->auth && !$this->iauth->elaAuthorize($imodule->elaGetRoles())) {
      unset($this->modules[$elakey]);
      return null;
    }
    $imodule->elaInit($this, $elakey);
    $this->imodules[$elakey] = $imodule;
  }
  return $this->imodules[$elakey];
}

// return first authorized module key
private function firstAuthorizedModuleKey() : string {
  $this->initAllModules();
  foreach ($this->modules as $elakey => $mod)
    return $elakey;
  if ($this->auth !== null)
    $this->iauth->elaLogout();
  throw new Exception\UnauthorizedException(__("You are not authorized to access any module!"));
}

private static function moduleToElakey($module) : string {
  if (is_string($module))
    return $module;
  if (!static::isModule($module))
    throw new Exception\Exception(__('Cannot get elakey of object which is not an Eladmin module.'));
  return $module->elakey();
}

// Returns true if user is authorized.
final public function auth($module, ?string $action = null) : bool {
  if ($this->auth === null)
    return true; // authorization off

  $module = $this->module(static::moduleToElakey($module));
  if ($module === null)
    return false; // user not authorized to work with the module
  return $this->iauth->elaAuthorize($module->elaGetRoles($action));
}

// override to add actions before the start of request proccessing
protected function prerun() : void {

}

// Render a view. Passes $args and instance of eladmin as $eladmin to the template.
final public function view(string $template, array $args = []) : string {
  return $this->blade->view()->make($template, array_merge($args, ['eladmin'=>$this]) )->render();
}

final public function accountFields() {
  return $this->iauth ? $this->iauth->elaAccountFields() : null;
}

// Return instances of all authorized modules.
final public function modules() : array {
  $this->initAllModules();
  return $this->imodules;
}

// Check if class is eladmin module.
final static public function isModule($class) : bool {
  return method_exists($class, 'elakey');
}

// Check if eladmin was run with ajax request.
final static public function isAjaxRequest() : bool {
  return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

// Redirect (or exit if ajax request). Default url = home
final static public function redirect(string $url = '.') : void {
  if (!static::isAjaxRequest())
    header('Location: '.$url);
  exit;
}

// Check if CSRF token is valid
final private function CSRFAuth() : void {
  if ( ($_GET['elatoken'] ?? null) !== $this->CSRFToken()) {
    throw new Exception\UnauthorizedException(__("CSRF token not valid! Try reloading page."));
  }
}

// Determinate asset content-type and print it.
private function renderAsset($assetpath) : void {
  if (strpos($assetpath, '..') !== false)
    throw new Exception\UnauthorizedException('Asset filename ' . $assetpath . ' cannot contain ".." due security issues.');

  $path_parts = pathinfo($assetpath);
  $extension = $path_parts['extension'];
  $assetContentTypes = [
    'css' => 'text/css',
    'js' => 'text/javascript'
  ];
  $contentType = $assetContentTypes[$extension] ?? null;
  if (!$contentType)
    throw new Exception\UnauthorizedException('Asset extension not allowed.');

  @$content = file_get_contents(__DIR__ . '/../assets/' . $assetpath);
  if ($content === false)
    throw new Exception\BadRequestException('Asset not found.');
  header('Content-type:'.$contentType);
  echo $content;
}

final public function elaActionAccount(){
  $this->iauth->elaAccount();
}

final public function elaActionAccountForm(){
  echo $this->view('accountForm');
}

// We want action keys to be case insensitive.
final static public function normalizeActionName(string $action) : string
{
  return strtolower($action);
}

// monolog Logger
final public function log() : object {
  return $this->log;
}

// e2e testing with consecutive.js
// TODO: change concept?
public function consecutiveScript()
{
  echo file_get_contents($this->consecutive);
}

protected function testinit()
{
}


private function initLocalization()
{
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

private function initSessions()
{
  $this->log->debug('init sessions');
  if(!session_id())
  {
    session_start();
  }
}

private function initBladeTemplates()
{
  $this->log->debug('init Blade');
  if(!$this->cache)
    throw new Exception\Exception('Set '.static::class.'::$cache property to a path to some writeable directory.');
  if (!file_exists($this->cache)) {
    $result = mkdir($this->cache);
    if (!$result)
      throw new Exception\Exception('Cannot create Blade cache directory '.$this->cache.'.');
  }
  if (!is_writeable($this->cache))
    throw new Exception\Exception('Cannot write to Blade cache directory '.$this->cache.'.');

  if (is_array($this->views)) {
    $views = array_merge($this->views, [__DIR__ . '/../views']);
  } else if (is_string($this->views)) {
    $views = [$this->views, __DIR__ . '/../views'];
  } else {
    $views = [__DIR__ . '/../views'];
  }
  $this->blade = new \Philo\Blade\Blade($views, $this->cache);
}

private function initAuthorization() {
  if ($this->auth) {
    $this->iauth = new $this->auth;
    if (!($this->iauth instanceof Auth\AuthInterface))
      throw new Exception\Exception(__('Authorization class %s does not implement Auth\AuthInterface.', $this->auth));

    $this->log->debug('init authorization');
    if (static::isModule($this->auth))
      $this->modules[] = $this->auth;
  }
}

private $allModulesInitialized = false;
private function initAllModules() {
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

// override default module elaTitle method
final public function elaTitle() : string {
  return $this->title();
}

}
