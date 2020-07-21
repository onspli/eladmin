<?php

namespace Onspli\Eladmin;
use \Onspli\Eladmin\Eladmin;
use \Onspli\Eladmin\Exception;
use \Jenssegers\Blade\Blade;

/**
* General Eladmin Module.
*
* To configure the module define properties as shown in the following example:
* ```php
* // set module's name
* protected $elaTitle = class_basename(static::class);
*
* // set module's icon
* protected $elaIcon = '<i class="fas fa-puzzle-piece"></i>';
*
* // set authorized roles. empty array means any role
* protected $elaRoles = ['admin', 'user'];
*
* // override to set authorized roles. empty array means any role.
* // It doesn't make sanse to have actions no one can perform.
* protected $elaActionRoles = ['read' => [], 'write' => ['admin']];
* ```
*/
trait Module {

/**
* Eladmin core instance
*/
private $eladmin = null;

/**
* Module's elakey
*/
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

/**
* normalizing action names for elaActionRoles is expensive, we want to do it only once
*/
private $elaActionNamesNormalized = false;

/**
* Each module has to be initialized with eladmin instance and its own elakey.
*/
final public function elaInit($eladmin, $elakey) : void {
  $eladmin->log()->debug('init module', ['class' => static::class, 'elakey' => $elakey]);
  $this->eladmin = $eladmin;
  $this->elakey = $elakey;
}

/**
* Check if module was initialized. Throws if it wasn't.
*/
final public function elaInitCheck() : void {
  if ($this->eladmin === null)
    throw new Exception(__('Module ' . static::class . ' was not initialized.'));
}

/**
* Each module has its elakey - index in modules array - used to address requests.
*/
final public function elakey() : string {
  $this->elaInitCheck();
  return $this->elakey;
}

/**
* Check if user is authorized to do action, or athorized to access module at all.
*/
final public function elaAuth(?string $action = null) : bool {
  $this->elaInitCheck();
  return $this->eladmin->auth($this, $action);
}

/**
* Get name of the module.
*/
public function elaTitle() : string {
  return $this->elaTitle ?? class_basename(static::class);
}

/**
* Get icon of the module.
*/
public function elaIcon() : string {
  return $this->elaIcon ?? '<i class="fas fa-puzzle-piece"></i>';
}

/**
* Return url for this module.
*/
final public function elaRequest($action = null, $args = []) : string {
  $this->elaInitCheck();
  return $this->eladmin->request($this->elakey(), $action, $args);
}

/**
* Create asset url, file path relative to /assets directory. Default $version = time()
*/
final public function elaAsset(string $path, ?string $version = null) : string {
  $this->elaInitCheck();
  return $this->eladmin->asset($this->elakey(), $path, $version);
}

/**
* Get roles authorized to work with the module, or specific action. Empty array means any role is authorized.
*/
final public function elaRoles($action = null) : array {
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

/**
* Set roles authorized to work with the module, or specific action. Empty array means any role is authorized.
*/
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

/**
* Actions will be called on instance of this module returned by this method. Default is $this.
*/
final public function elaInstanceForAction() : object {
  return $this;
}

/**
* Extends array of directories of views and assets
*/
public function elaViews() : array {
  return [__DIR__ . '/../views/module'];
}

/**
* Return Blade instance
*/
public function eleBlade() : Blade {
  $this->elaInitCheck();
  return $this->eladmin->blade($this->elaViews());
}

/**
* Return rendered view.
*/
final public function elaView(string $name, array $args = []) : string {
  $this->elaInitCheck();
  $blade = $this->eleBlade();
  return $this->eladmin->view($name, array_merge($args, ['module' => $this]), $blade);
}

/**
* Determinate asset content-type and print it.
*/
public function elaFile($path) : void {
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


}
