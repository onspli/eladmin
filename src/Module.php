<?php

namespace Onspli\Eladmin\Module;
use \Onspli\Eladmin;
use \Onspli\Eladmin\Exception;


trait Module
{

private $eladmin = null;
private $elakey = null;

/**
* I am getting 'Indirect modification has no efect' if the property is not explicitly declared from some reason.
* But it cannot be, because this is a trait and it shall be overriden.
* So I declared this property and elaAuthorizedRolesActions is copied to it during init.
*/
protected $_elahack_elaAuthorizedRolesActions = [];

public function elaInit($eladmin, $elakey){
  $eladmin->log->debug('init module', ['class' => static::class, 'elakey' => $elakey]);
  $this->eladmin = $eladmin;
  $this->elakey = $elakey;
}

// Each module has its elakey - index in modules array - used to address requests.
final public function elakey() : string{
  return $this->elakey;
}

final public function elaAuth(?string $action = null) : bool {
  return $this->eladmin->auth($this, $action);
}

public function elaGetTitle(): string {
  return $this->elaTitle??class_basename(static::class);
}

public function elaGetIcon(): string {
  return $this->elaIcon??'<i class="fas fa-puzzle-piece"></i>';
}

final public function elaGetAuthorizedRoles(): array{
  return $this->elaAuthorizedRoles??[];
}

private $elaActionNamesNormalized = false;
final public function elaGetAuthorizedRolesActions(): array{
  if(!$this->elaActionNamesNormalized)
  {
    $this->elaActionNamesNormalized = true;
    // normalize action names
    $authRoles = $this->elaAuthorizedRolesActions??[];
    $this->eladmin->log->debug('normalize action names', ['module'=>static::class, 'elakey'=>$this->elakey]);
    foreach($authRoles as $action=>$roles)
    {
      $this->elaSetAuthorizedRolesAction($action, $roles);
    }
  }
  return $this->_elahack_elaAuthorizedRolesActions??[];
}

final public function elaSetAuthorizedRolesAction($action, $roles){
  if(!is_array($roles)) $roles = [$roles];
  $action = $this->eladmin->normalizeActionName($action);
  $this->_elahack_elaAuthorizedRolesActions[$action] = $roles;
}

final public function elaRequest($action = null, $args=[]) : string{
  return $this->eladmin->request($this->elakey(), $action, $args);
}

// override to set views prefix (directory)
protected function elaViewsPrefix(): string{
  return 'modules.module.';
}

final public function elaGetView(string $key): string{
  return $this->elaViewsPrefix() . $key;
}

final public function elaView(string $name, array $args=[]) : string
{
  $name = $this->elaGetView($name);
  return $this->eladmin->view($name, array_merge($args, ['module'=>$this]));
}

public function elaGetActionInstance(){
  return $this;
}

final public function elaAction_script(){
  header('Content-type:text/javascript');
  echo $this->elaView('script');
}

final public function elaOutText(?string $str = null){
  Header('Content-type: text/plain');
  if($str !== null) echo $str;
}

final public function elaOutHtml(?string $str = null){
  Header('Content-type: text/html');
  if($str !== null) echo $str;
}

final public function elaOutJson(?array $json = null){
  Header('Content-type: application/json');
  if($json !== null) echo json_encode($json, JSON_UNESCAPED_UNICODE);
}

}
