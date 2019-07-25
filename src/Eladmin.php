<?php

namespace Onspli\Eladmin;

class Eladmin
{

  /**
  * Register admin modules (i.e. eloquent models).
  */
  protected $modules = [];
  protected $imodules = [];

  /**
  * Blade configuration
  */
  protected $bladeViews = __DIR__ . '/../views';
  protected $bladeCache = __DIR__ . '/../cache';
  protected $blade = null;

  /**
  * Authorization manager.
  */
  protected $authorization = User::class;
  protected $iauthorization = null;

  public function __construct(){
    if(!session_id()) session_start();

    $this->blade = new \Philo\Blade\Blade($this->bladeViews, $this->bladeCache);

    /**
    * TODO: Ověřit authorization interface
    */
    if($this->authorization){
      $this->modules[] = $this->authorization;
      $this->iauthorization = new $this->authorization();
    }

    /**
    * TODO: kontrola, zda jsou třídy správného typu (Eloquent model nebo Eladmin module)
    */
    foreach($this->modules as $key=>$module){
      $imodule = new $module();
      if($this->authorization && !$this->iauthorization->elaAuth($imodule->elaGetAuthorizedRoles())){
        unset($this->modules[$key]);
        continue;
      }
      $this->imodules[$key] = $imodule;
    }
  }

  /**
  * Do the magic.
  */
  public function run(): void
  {
    if($this->authorization){



      $isLogout = $_POST['elalogout']??$_GET['elalogout']??false;
      if($isLogout){
        $this->iauthorization->elaLogout();
        if(!$this->isAjaxCall()){
          Header('location:.');
          return;
        }
      }

      $isLogin = $_POST['elalogin']??$_GET['elalogin']??false;
      if($isLogin){
        $this->iauthorization->elaLogin();
        if(!$this->isAjaxCall()){
          Header('location:.');
          return;
        }
      }

      $isAuthorized = $this->iauthorization->elaAuth();
      $loginFields = $this->iauthorization->elaLoginFields();
      if(!$isAuthorized && ($loginFields === null || $isLogin)){
        header("HTTP/1.1 401 Unauthorized");
        echo "Neplatné přihlašovací údaje!";
        return;
      }
      if(!$isAuthorized){
        if(!$this->isAjaxCall())
          echo $this->view('login', ['loginFields'=>$loginFields]);
        return;
      }
    }

    $elamodule = $_GET['elamodule']??null;
    $elaaction = $_GET['elaaction']??null;
    $elatoken = $_GET['elatoken']??null;
    if($elamodule === null || $elamodule === ''){

      if($elaaction == 'csrftoken'){
        echo $this->getCSRFToken();
        return;
      }

      if(!$elaaction){
        echo $this->view('hello');
        return;
      }

      if($elatoken != $this->getCSRFToken()){
        header("HTTP/1.1 401 Unauthorized");
        echo "CSRF token not valid!";
        return;
      }

      if($elaaction == 'account'){



        try{
          $this->iauthorization->elaAccount();
        } catch(\Exception $e){
          header("HTTP/1.1 400 Bad Request");
          echo $e->getMessage();
          return;
        }
        if(!$this->isAjaxCall())
          Header('location:.');
        return;
      }

      header("HTTP/1.1 400 Bad Request");
      echo 'No action!';
      return;

    }



    try{
      if(!isset($this->modules[$elamodule]))
        throw new \Exception('Requested module does not exist.');

      $imodule = $this->imodules[$elamodule];
      $module = $this->modules[$elamodule];

      if($elaaction === null){
        echo $this->view('module', ['module'=>$module, 'elamodule'=>$elamodule, 'title'=>$imodule->elaGetTitle(), 'js'=>$imodule->elaGetJs()]);
        return;
      }

      if($elatoken != $this->getCSRFToken()){
        header("HTTP/1.1 401 Unauthorized");
        echo "CSRF token not valid!";
        return;
      }

      $method = $this->getActionMethodName($elaaction);

      if(!method_exists($imodule, $method))
        throw new \Exception('Module "'.$module.'" has not defined action method "'.$method.'".');
      call_user_func(array($imodule, $method));

    } catch(\Exception $e){
      header("HTTP/1.1 400 Bad Request");
      echo $e->getMessage();
      return;
    }
  }

  protected function getCSRFToken(){
    $token = $_SESSION['elacsrftoken']??null;
    if(!$token){
      $token = $_SESSION['elacsrftoken'] = $this->randomString(16);
    }
    return $token;
  }

  private function randomString($len){
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $res = '';
    for($i=0; $i<$len; $i++)
     $res .= substr($chars, rand(0, strlen($chars)-1), 1);
    return $res;
  }

  protected function getActionMethodName($action){
    return 'elaAction'.ucfirst($action);
  }


  /**
  * Render a view.
  */
  protected function view($name, $args=[]){
    return $this->blade->view()->make($name, $args+[
      'modules'=>$this->imodules,
      'useauth'=>!is_null($this->authorization),
      'accountfields'=>$this->iauthorization?$this->iauthorization->elaAccountFields():null,
      'csrftoken'=>$this->getCSRFToken()
      ])->render();
  }

  protected function isAjaxCall(){
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
      return true;
    return false;
  }
}
