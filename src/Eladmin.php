<?php

namespace Onspli\Eladmin;

class Eladmin
{

  protected $title = "Eladmin";
  protected $lang = "en_US";

  /**
  * Register admin modules (i.e. eloquent models).
  */
  protected $modules = [];  // class names
  protected $imodules = []; // instances

  /**
  * Blade configuration
  */
  protected $views = [];
  protected $cache = null;
  public $blade = null;

  /**
  * Authorization manager.
  */
  protected $auth = User::class; // class name
  protected $iauth = null;       // instance
  public $disableNoAuthorizationMessage = false;

  // gettext translator
  public $t;

  protected function defaultProperties(){

  }

  public function __toString(){
    return '';
  }


  public function __construct(){
    $this->defaultProperties();
    try{
      $this->t = new \Gettext\Translator();
      $translations = \Gettext\Translations::fromPoFile(__DIR__.'/../locale/'.$this->lang.'/LC_MESSAGES/messages.po');
      $this->t->loadTranslations($translations);
    } catch(\Exception $e){
      throw new \Exception('Locale "'.$this->lang.'" is not supported.');
    }


  /*
    $this->t = new \Gettext\GettextTranslator();
    $this->t->setLanguage($this->lang);
    $this->t->loadDomain('messages', __DIR__.'/../locale');
    */
    $this->t->register();

    if(!$this->cache)
      throw new \Exception('Give '.static::class.'->cache property a path to some writeable directory.');

    if(!session_id()) session_start();

    if(is_array($this->views))
      $views = array_merge($this->views, [__DIR__ . '/../views']);
    else
      $views = [$this->views, __DIR__ . '/../views'];
    $this->blade = new \Philo\Blade\Blade($views, $this->cache);

    /**
    * TODO: Ověřit auth interface
    */
    if($this->auth){
      $this->modules[] = $this->auth;
      $this->iauth = new $this->auth;
    }

    /**
    * TODO: kontrola, zda jsou třídy správného typu (Eloquent model nebo Eladmin module)
    */
    foreach($this->modules as $key=>$module){
      $imodule = new $module();
      if($this->auth && !$this->iauth->elaAuthorize($imodule->elaGetAuthorizedRoles())){
        unset($this->modules[$key]);
        continue;
      }
      $imodule->elaInit($this, $key);
      $this->imodules[$key] = $imodule;
    }
  }

  public function title(){
    return $this->title;
  }

  /**
  * Returns true if user is authorized.
  */
  public function auth($action, $module): bool{
    if(!$this->iauth) return true; // authorization off

    if(!$action){
      if(!$this->iauth->elaAuthorize($module->elaGetAuthorizedRoles())) return false;
      else return true;
    }

    // Check if user is authorized to do the action
    $authroles = $module->elaGetAuthorizedRolesActions()[static::normalizeActionName($action)]??[];
    if(!$this->iauth->elaAuthorize($authroles)) return false;
    return true;
  }

  public function elaAuth($action){
    return $this->auth($action, $this);
  }

  public function elakey(){
    return (string)'';
  }

  /**
  * Returns username or null if authorization is off.
  */
  public function username(): ?string{
    return $this->iauth? $this->iauth->elaUserName():null;
  }

  public function accountFields(){
    return $this->iauth? $this->iauth->elaAccountFields() :null;
  }


  public function modules(){
    return $this->imodules;
  }

  public function action(): ?string{
    if(!isset($_GET['elaaction'])) return null;
    return $this->normalizeActionName($_GET['elaaction']);
  }

  public function modulekey(): ?string{
    $key = $_GET['elamodule']??null;
    if($key === null)
      foreach($this->modules as $key=>$mod)
        return $key;
    return $key;
  }

  public function module($key=null){
    if($key === "" || ($key === null && $this->moduleKey() === "")) return $this;
    if(!isset($this->imodules[$key??$this->moduleKey()]))
      throw new Exception\BadRequestException(__('Unknown module "%s"!', $key??$this->moduleKey()));
    return $this->imodules[$key??$this->moduleKey()];
  }

  public function request($action, $module, $args=[]){
    $data = $args;
    if($action) $data['elaaction'] = $action;
    $data['elamodule'] = (string)$module;
    $data['elatoken'] = $this->CSRFToken();
    return '?'.http_build_query($data);
  }

  /**
  * Render a view.
  */
  public function view($name, $args=[]){
    return $this->blade->view()->make($name, array_merge($args, ['eladmin'=>$this]) )->render();
  }

  public function CSRFToken(){
    $token = $_SESSION['elacsrftoken']??null;
    if(!$token){
      $token = '';
      $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      for($i=0; $i<16; $i++)
       $token .= substr($chars, rand(0, strlen($chars)-1), 1);
      $_SESSION['elacsrftoken'] = $token;
    }
    return $token;
  }

  protected function CSRFAuth(){
    if(($_GET['elatoken']??null) != $this->CSRFToken())
      throw new Exception\UnauthorizedException(__("CSRF token not valid! Try reloading page."));
  }

  private function isAjaxCall(){
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') return true;
    return false;
  }

  private function refreshNoAjax(){
    if($this->isAjaxCall()) return;
    Header('Location: .');
    exit;
  }


  /**
  * Run Eladmin. It's just a wrapper of method runNoCatch catching exceptions.
  */
  public function run():void
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

  /**
  * Run Eladmin.
  */
  public function runNoCatch(): void
  {
    /**
    * Authentication and authorization.
    */
    if($this->auth){
      $isLogout = $_GET['elalogout']??false;
      if($isLogout){
        $this->iauth->elaLogout();
        $this->refreshNoAjax();
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
    if(!$this->action()){
      if($this->module() == $this)
        echo $this->view('hello');
      else
        echo $this->view('module', ['module'=>$this->module()]);
      return;
    }

    // CSRF token comparsion
    $this->CSRFAuth();

    // Check if user is authorized to do the action
    if(!$this->module()->elaAuth($this->action()))
      throw new Exception\UnauthorizedException();

    // do the action
    if($this->module() == $this) $classname = static::class;
    else $classname = $this->modules[$this->moduleKey()];
    if(!is_callable([$this->module(), 'elaAction'.ucfirst($this->action())]))
      throw new Exception\BadRequestException('Class '.$classname.' does not have method '.'elaAction'.ucfirst($this->action()).'!');
    $actionInstance = $this->module()->elaGetActionInstance();
    call_user_func([$actionInstance, 'elaAction'.ucfirst($this->action())]);
  }

  public function elaGetAuthorizedRolesActions(){
    return [];
  }

  public function elaGetAuthorizedRoles(){
    return [];
  }

  public function elaActionAccount(){
    $this->iauth->elaAccount();
  }

  public function elaActionAccountForm(){
    echo $this->view('accountForm');
  }

  public function elaGetActionInstance(){
    return $this;
  }

  static public function compareActionNames($act1, $act2){
    return (static::normalizeActionName($act1) == static::normalizeActionName($act2));
  }

  static public function normalizeActionName($action){
    return strtolower($action);
  }



}
