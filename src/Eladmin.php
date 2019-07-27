<?php

namespace Onspli\Eladmin;

class Eladmin
{

  protected $title = "Eladmin";

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
  protected $blade = null;

  /**
  * Authorization manager.
  */
  protected $auth = User::class; // class name
  protected $iauth = null;       // instance
  public $disableNoAuthorizationMessage = false;

  public function __construct(){
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
      $this->iauth->bladeCache = $this->cache;
    }

    /**
    * TODO: kontrola, zda jsou třídy správného typu (Eloquent model nebo Eladmin module)
    */
    foreach($this->modules as $key=>$module){
      $imodule = new $module();
      if($this->auth && !$this->iauth->elaAuth($imodule->elaGetAuthorizedRoles())){
        unset($this->modules[$key]);
        continue;
      }
      $imodule->eladmin = $this;
      $this->imodules[$key] = $imodule;
    }
  }

  public function title(){
    return $this->title;
  }

  /**
  * Returns true if user is authorized.
  */
  public function auth($action=null, $module=null): bool{
    if(!$this->iauth) return true; // authorization off

    if(!$action){
      if(!$this->iauth->elaAuth($this->module($module)->elaGetAuthorizedRoles())) return false;
      else return true;
    }

    // Check if user is authorized to do the action
    $authroles = $this->module($module)->elaGetAuthorizedRolesActions()[strtolower($action)]??[];
    if(!$this->iauth->elaAuth($authroles)) return false;
    return true;
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

  public function action(){
    return $_GET['elaaction']??null;
  }

  public function moduleKey(){
    return $_GET['elamodule']??null;
  }

  public function module($key=null){
    return $this->imodules[$key??$this->moduleKey()]??$this;
  }

  public function request($action, $moduleKey=null, $args=[]){
    $data = $args;
    if($action) $data['elaaction'] = $action;
    $data['elamodule'] = $moduleKey??$this->moduleKey();
    $data['elatoken'] = $this->CSRFToken();
    return '?'.http_build_query($data);
  }

  /**
  * Render a view.
  */
  public function view($name, $args=[]){
    return $this->blade->view()->make($name, $args+['eladmin'=>$this, 'elaModule'=>$this->module()])->render();
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
      throw new Exception\UnauthorizedException("CSRF token not valid!");
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
      if($isLogin) $this->iauth->elaLogin();

      $isAuthorized = $this->iauth->elaAuth();
      if($isLogin){
        if(!$isAuthorized)
          throw new Exception\UnauthorizedException("Neplatné přihlašovací údaje!");
        else
          $this->refreshNoAjax();
        return;
      }

      $loginFields = $this->iauth->elaLoginFields();
      if(!$isAuthorized){
        if($this->isAjaxCall())
          throw new Exception\UnauthorizedException("Neautorizovaný přístup!");
        if($loginFields === null)
          throw new Exception\UnauthorizedException("Neautorizovaný přístup!");
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
        echo $this->view('hello', ['elaModule'=>$this->module()]);
      else
        echo $this->view('module', ['elaModule'=>$this->module()]);
      return;
    }

    // CSRF token comparsion
    $this->CSRFAuth();

    // Check if user is authorized to do the action
    if(!$this->auth($this->action()))
      throw new Exception\UnauthorizedException("Not authorized!");

    // do the action
    call_user_func([$this->module(), 'elaAction'.ucfirst($this->action())]);
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



}
