<?php

namespace Onspli\Eladmin;

class Eladmin
{

// override to set administration title
protected $title = "Eladmin";
// override to set language
protected $lang = "en_US";
// override to register admin modules (i.e. eloquent models).
protected $modules = [];
// required: override to set cache directory
protected $cache = null;
// override to set blade views directory, either string or array
protected $views = null;
// override to use advanced authorization null to disable authorization completely
protected $auth = User::class;
// override to set monolog report level, null for no output
protected $logLevel = null;

// modules instances
private $imodules = [];
// authorization instance
private $iauth = null;
// blade template engine instance
private $blade = null;
// gettext translator
private $t;
// monolog Logger
public $log;

// TODO: change concept of testing?
public $consecutive = false;

// Initialize Eladmin.
final public function __construct()
{
  $this->initMonolog();
  $this->log->info('Construct eladmin.', $_GET);
}

final public function versionName() {
  return "v0.2.2-alpha";
}

// Run Eladmin. It's just a wrapper of method runNoCatch catching exceptions.
final public function run() : void
{
  try{
    $this->runNoCatch();
  } catch(Exception\UnauthorizedException $e){
    header("HTTP/1.1 401 Unauthorized");
    echo $e->getMessage();
  } catch(Exception\BadRequestException $e){
    header("HTTP/1.1 400 Bad Request");
    echo $e->getMessage();
  } catch(Exception\Exception $e){
    header("HTTP/1.1 500 Internal Server Error");
    echo $e->getMessage();
  } catch(\Exception $e){
    header("HTTP/1.1 500 Internal Server Error");
    echo $e->getMessage();
  }
}

// Return administration title to show it in templates.
final public function title() : string
{
  return $this->title;
}

// Returns username to show it in templates. Returns null if authorization is off.
final public function username() : ?string{
  return $this->iauth ? $this->iauth->elaUserName() : null;
}

// Each module has its elakey - index in modules array - used to address requests.
// Empty for eladmin.
final public function elakey() : string
{
  return '';
}

// Return requested action key, null if no action requested
private $requested_actionkey = null; // caching
final public function actionkey() : ?string
{
  if ($this->requested_actionkey === null && isset($_GET['elaaction']))
  {
    $this->requested_actionkey = static::normalizeActionName($_GET['elaaction']);
  }
  return $this->requested_actionkey;
}

// Return requested asset path, null if no asset requested
final public function assetpath() : ?string
{
  return $_GET['elaasset'] ?? null;
}

// Return requested module key, null if no module requested
private $requested_modulekey = null; // caching
final public function modulekey() : ?string
{
  if ($this->requested_modulekey !== null)
  {
    return $this->requested_modulekey;
  }
  $this->requested_modulekey = $_GET['elamodule'] ?? null;
  return $this->requested_modulekey;
}

// return first authorized module key
private function firstAuthorizedModuleKey() : string
{
  foreach($this->modules as $key=>$mod)
  {
    return $key;
  }
  throw new Exception\UnauthorizedException(__("You are not authorized to access any module!") .' <a href="?elalogout=true">'. __("Logout") .'</a>');
}

// Generate CSRF token
final public function CSRFToken() : string
{
  $token = $_SESSION['elacsrftoken'] ?? null;
  if(!$token)
  {
    $token = '';
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for($i=0; $i<16; $i++)
    {
      $token .= substr($chars, rand(0, strlen($chars)-1), 1);
    }
    $_SESSION['elacsrftoken'] = $token;
  }
  return $token;
}

// create request url
final public function request(?string $action, $module, array $args=[]) : string
{
  $data = $args;
  if($action !== null)
  {
    $data['elaaction'] = $action;
    $data['elatoken'] = $this->CSRFToken();
  }
  if (is_string($module)) $data['elamodule'] = $module;
  else $data['elamodule'] = $module->elakey();
  return '?'.http_build_query($data);
}

// create asset url, file path relative to /assets directory
final public function asset(string $file, ?string $version=null) : string
{
  $data['elaasset'] = $file;
  $data['ver'] = $version ?? time();
  return '?'.http_build_query($data);
}

// Returns true if user is authorized.
final public function auth(?string $action, $module) : bool
{
  if(!$this->iauth) return true; // authorization off

  if (is_string($module))
  {
    $module = $this->module($module);
  }

  if($action === null)
  {
    if(!$this->iauth->elaAuthorize($module->elaGetAuthorizedRoles())) return false;
    else return true;
  }

  // Check if user is authorized to do the action
  $authroles = $module->elaGetAuthorizedRolesActions()[static::normalizeActionName($action)]??[];
  if(!$this->iauth->elaAuthorize($authroles)) return false;
  return true;
}

// override to add actions before the start of request proccessing
protected function prerun() : void
{

}

// Run Eladmin. The main function which processes the requests.
final public function runNoCatch(): void
{
  $this->prerun();

  $asset = $this->assetpath();
  if ($asset !== null)
  {
    $this->printAsset($asset);
    return;
  }

  $testinit = $_GET['elatestinit']??null;
  if ($testinit)
  {
    $this->testinit();
    return;
  }

  $this->initLocalization();
  $this->initSessions();
  $this->initBladeTemplates();
  $this->initAuthorization();

  /**
  * Authentication and authorization.
  */
  if($this->auth){
    $isLogout = $_GET['elalogout']??false;
    if($isLogout){
      $this->iauth->elaLogout();
      $this->refreshNoAjax();
      throw new Exception\UnauthorizedException();
    }

    $isLogin = $_GET['elalogin']??false;
    if($isLogin){
      $this->iauth->elaLogin();
    }

    $isAuthorized = $this->iauth->elaAuthorize();
    if($isLogin){
      if(!$isAuthorized)
        throw new Exception\UnauthorizedException(__("Wrong credentials!"));
      else
        $this->refreshNoAjax();
      return;
    }

    $loginFields = $this->iauth->elaLoginFields();
    if(!$isAuthorized){
      if($this->isAjaxCall())
        throw new Exception\UnauthorizedException();
      if($loginFields === null)
        throw new Exception\UnauthorizedException();
      else{
        echo $this->view('login', ['loginFields'=>$loginFields]);
        return;
      }
    }
    // it is not an attempt to login and user is authorized to continue execution
  }

  // no action, render module view
  if(!$this->actionkey()){
    $this->initAllModules();
    if($this->modulekey() === null)
    {
      $url = $this->request(null, $this->firstAuthorizedModuleKey());
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

  // Check if user is authorized to do the action
  if(!$this->module()->elaAuth($this->actionkey()))
    throw new Exception\UnauthorizedException();

  // do the action
  if($this->module() == $this) $classname = static::class;
  else $classname = $this->modules[$this->moduleKey()];
  if(!is_callable([$this->module(), 'elaAction'.$this->actionkey()]))
    throw new Exception\BadRequestException('Class '.$classname.' does not have method '.'elaAction'.ucfirst($this->actionkey()).'!');
  $actionInstance = $this->module()->elaGetActionInstance();
  call_user_func([$actionInstance, 'elaAction'.$this->actionkey()]);
}

// Render a view.
final public function view(string $name, array $args=[]) : string
{
  return $this->blade->view()->make($name, array_merge($args, ['eladmin'=>$this]) )->render();
}

// authorize eladmin action
final public function elaAuth($action) : bool
{
  return $this->auth($action, $this);
}

final public function accountFields()
{
  return $this->iauth ? $this->iauth->elaAccountFields() : null;
}

// Return instances of all modules.
final public function modules()
{
  return $this->imodules;
}

// Return module instance or null if not authorized. Call without argument to get requested module instance.
final public function module(?string $key=null)
{
  $key = $key ?? $this->modulekey();
  if ($key === null)
    throw new Exception\BadRequestException(__('No module requested!'));
  if($key === "") return $this;
  // has the module been initialized?
  if(!isset($this->imodules[$key]))
  {
    $moduleclass = $this->modules[$key] ?? null;
    if (!$moduleclass)
    {
      throw new Exception\BadRequestException(__('Unknown module "%s"!', $key));
    }
    $imodule = new $moduleclass();
    if($this->auth && !$this->iauth->elaAuthorize($imodule->elaGetAuthorizedRoles()))
    {
      unset($this->modules[$key]);
      return null;
    }
    $imodule->elaInit($this, $key);
    $this->imodules[$key] = $imodule;
  }
  return $this->imodules[$key];
}

// Check CSRF token
private function CSRFAuth() : void
{
  if(($_GET['elatoken']??null) !== $this->CSRFToken())
  {
    throw new Exception\UnauthorizedException(__("CSRF token not valid! Try reloading page."));
  }
}

static private function isAjaxCall() : bool
{
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') return true;
  return false;
}

static private function refreshNoAjax() : void
{
  if(static::isAjaxCall()) return;
  Header('Location: .');
  exit;
}

static private function redirect($url) : void
{
  if(static::isAjaxCall()) exit;
  Header('Location: '.$url);
  exit;
}

// Determinate asset content-type and print it.
private function printAsset($assetpath) : void
{
  if(strpos($assetpath, '..') !== false){
    throw new Exception\UnauthorizedException("Asset filename '.$assetpath.' cannot contain '..' due security issues.");
  }
  $path_parts = pathinfo($assetpath);
  $extension = $path_parts['extension'];
  $assetContentTypes = [
    'css' => 'text/css',
    'js' => 'text/javascript'
  ];
  $contentType = $assetContentTypes[$extension]??null;
  if(!$contentType){
    throw new Exception\UnauthorizedException("Asset extension not allowed.");
  }
  @$content = file_get_contents(__DIR__.'/../assets/'.$assetpath);
  if($content === false){
    throw new Exception\BadRequestException("Asset not found.");
  }
  header('Content-type:'.$contentType);
  echo $content;
}

final public function elaGetAuthorizedRolesActions(){
  return [];
}

final public function elaGetAuthorizedRoles(){
  return [];
}

final public function elaActionAccount(){
  $this->iauth->elaAccount();
}

final public function elaActionAccountForm(){
  echo $this->view('accountForm');
}

// Get module instance to call elaActionMethod.
final public function elaGetActionInstance(){
  return $this;
}

// We want action keys to be case insensitive.
final static public function normalizeActionName(string $action) : string
{
  return strtolower($action);
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
  {
    throw new \Exception('Give '.static::class.'->cache property a path to some writeable directory.');
  }
  if (is_array($this->views))
  {
    $views = array_merge($this->views, [__DIR__ . '/../views']);
  }
  else if (is_string($this->views))
  {
    $views = [$this->views, __DIR__ . '/../views'];
  }
  else
  {
    $views = [__DIR__ . '/../views'];
  }
  $this->blade = new \Philo\Blade\Blade($views, $this->cache);
}

private function initAuthorization()
{
  /**
  * TODO: Check auth interface
  */
  if($this->auth){
    $this->log->debug('init authorization');
    // TODO: should we add auth to modules?
    $this->modules[] = $this->auth;
    $this->iauth = new $this->auth;
  }
}

private function initAllModules()
{
  $this->log->debug('init all modules');
  /**
  * TODO: check modules parents (Eloquent model or Eladmin module)
  */
  foreach($this->modules as $key=>$module)
  {
    $this->module($key);
  }
}

private function initMonolog() : void
{
  $this->log = new \Monolog\Logger('log');
  if ($this->logLevel !== null){
    $this->log->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__.'/debug.log', $this->logLevel));
  }
}

}
