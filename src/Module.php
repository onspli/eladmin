<?php

namespace Onspli\Eladmin;
use \Onspli\Eladmin\Eladmin;
use \Onspli\Eladmin\Exception;

trait Module {

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
final public function elaInit($eladmin, $elakey) {
  $eladmin->log()->debug('init module', ['class' => static::class, 'elakey' => $elakey]);
  $this->eladmin = $eladmin;
  $this->elakey = $elakey;
}

// Check if module was initialized.
final public function elaInitCheck() : void {
  if ($this->eladmin === null)
    throw new Exception(__('Module ' . static::class . ' was not initialized.'));
}

// Each module has its elakey - index in modules array - used to address requests.
final public function elakey() : string {
  $this->elaInitCheck();
  return $this->elakey;
}

// Check if user is authorized to do action, or athorized to access module at all.
final public function elaAuth(?string $action = null) : bool {
  $this->elaInitCheck();
  return $this->eladmin->auth($this, $action);
}

// Get name of the module.
public function elaGetTitle() : string {
  return $this->elaTitle ?? class_basename(static::class);
}

// Get icon of the module.
public function elaGetIcon() : string {
  return $this->elaIcon ?? '<i class="fas fa-puzzle-piece"></i>';
}

// Return url for this module.
final public function elaRequest($action = null, $args = []) : string {
  $this->elaInitCheck();
  return $this->eladmin->request($this->elakey(), $action, $args);
}

// Get roles authorized to work with the module, or specific action. Empty array means any role is authorized.
final public function elaGetRoles($action = null) : array {
  if ($action === null)
    return $this->elaRoles ?? [];

  if (!isset($this->elaActionRoles)) {
    $this->elaActionNamesNormalized = true;
    return [];
  }

  if (!$this->elaActionNamesNormalized) {
    $actionRolesCopy = (new \ArrayObject($this->elaActionRoles))->getArrayCopy();
    $this->elaActionRoles = [];
    foreach ($actionRolesCopy as $action => $roles) {
      $this->elaSetRoles($roles, $action);
    }
    $this->elaActionNamesNormalized = true;
  }

  $action = Eladmin::normalizeActionName($action);
  return $this->elaActionRoles[$action] ?? [];
}

// Set roles authorized to work with the module, or specific action. Empty array means any role is authorized.
final public function elaSetRoles(array $roles, $action = null) : void {
  if ($action === null) {
    $this->elaRoles = $roles;
    return;
  }

  if (!isset($this->elaActionRoles) || !is_array($this->elaActionRoles))
    $this->elaActionRoles = [];

  $action = Eladmin::normalizeActionName($action);
  $this->elaActionRoles[$action] = $roles;
}

// Actions will be called on instance of this module returned by this method. Default is $this.
final public function elaGetInstanceForAction() : object {
  return $this;
}

// Convinient method for plain text output. Sets HTTP header text/plain and echo $str.
final static public function elaOutText(?string $str = null) : void {
  Header('Content-type: text/plain');
  if($str !== null) echo $str;
}

// Convinient method for html output. Sets HTTP header text/html and echo $str.
final static public function elaOutHtml(?string $str = null) : void {
  Header('Content-type: text/html');
  if($str !== null) echo $str;
}

// Convinient method for json output. Sets HTTP header application/json and echo serialized $json.
final static public function elaOutJson(?array $json = null) : void {
  Header('Content-type: application/json');
  if($json !== null) echo json_encode($json, JSON_UNESCAPED_UNICODE);
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

final public function elaAction_script(){
  header('Content-type:text/javascript');
  echo $this->elaView('script');
}

}
