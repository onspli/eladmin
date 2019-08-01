<?php

namespace Onspli\Eladmin\Module;
use \Onspli\Eladmin;
use \Onspli\Eladmin\Exception;


trait Module
{

  public $eladmin = null;
  public $elakey = null;

  /**
  * I am getting 'Indirect modification has no efect' if the property is not explicitly declared from some reason.
  * But it cannot be, because this is a trait and it shall be overriden.
  * So I declared this property and elaAuthorizedRolesActions is copied to it during init.
  */
  protected $_elahack_elaAuthorizedRolesActions = [];

  public function elaInit($eladmin, $elakey){
    $this->eladmin = $eladmin;
    $this->elakey = $elakey;
    // normalize action names
    $authRoles = $this->elaAuthorizedRolesActions??[];
    $this->_elahack_elaAuthorizedRolesActions = [];
    foreach($authRoles as $action=>$data)
      $this->_elahack_elaAuthorizedRolesActions[$this->eladmin::normalizeActionName($action)] = $data;
  }

  public function elakey(){
    return (string)$this->elakey;
  }

  public function elaAuth($action): bool{
    return $this->eladmin->auth($action, $this);
  }

  public function elaGetTitle(): string {
    return $this->elaTitle??class_basename(static::class);
  }

  public function elaGetIcon(): string {
    return $this->elaIcon??'<i class="fas fa-puzzle-piece"></i>';
  }

  public function elaGetAuthorizedRoles(): array{
    return $this->elaAuthorizedRoles??[];
  }

  public function elaGetAuthorizedRolesActions(): array{
    return $this->_elahack_elaAuthorizedRolesActions??[];
  }

  public function elaSetAuthorizedRolesAction($action, $roles){
    if(!is_array($roles)) $roles = [$roles];
    $action = $this->eladmin->normalizeActionName($action);
    $this->_elahack_elaAuthorizedRolesActions[$action] = $roles;
  }

  public function elaRequest($action, $args=[]){
    return $this->eladmin->request($action, $this->elakey(), $args);
  }

  protected function elaViewsDef(): array{
    return [
      'render'=>'modules.module.render'
    ];
  }

  public function elaGetView($key): string{
    return ($this->elaViews??$this->elaViewsDef())[$key];
  }

  public function elaGetActionInstance(){
    return $this;
  }

  public function elaOutText($str=null){
    Header('Content-type: text/plain');
    if($str !== null) echo $str;
  }

  public function elaOutHtml($str=null){
    Header('Content-type: text/html');
    if($str !== null) echo $str;
  }

  public function elaOutJson(?array $json = null){
    Header('Content-type: application/json');
    if($json !== null) echo json_encode($json, JSON_UNESCAPED_UNICODE);
  }

}
