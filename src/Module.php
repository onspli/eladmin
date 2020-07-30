<?php

namespace Onspli\Eladmin;
use \Onspli\Eladmin;
use \Onspli\Eladmin\Exception;
use \Jenssegers\Blade\Blade;

/**
* Generic Eladmin module.
*
* Features:
*
* - define module's apearence in admin interface - $title, $icon, title(), icon()
* - handles authorization - $roles, $actionRoles, auth(), getRoles(), setRoles()
* - handles rendering - requestUrl(), assetUrl(), view(), asset(), views(), blade()
* - user defined actions - action<action name>(), actions(), hasAction()
*
*
* To configure the module you may define properties as shown in the following example.
* ```lang-php
* class MyModule extends Eladmin\Module {
*
* // set module's name
* protected $title = 'My module';
*
* // set module's icon
* protected $icon = '<i class="fas fa-puzzle-piece"></i>';
*
* // set authorized roles.
* protected $roles = ['admin', 'user'];
*
* // override to set authorized roles. empty array means any role.
* protected $actionRoles = ['read' => self::ANYONE, 'write' => ['admin'], 'delete' => self::NOONE];
*
* }
* ```
*
* Views directory structure:
* ```
* render.blade.php   - module content
* assets/style.css   - module style
* assets/script.css  - module scripts
* ```
*
*/
class Module {

/**
* Eladmin core instance
*/
private $core = null;

/**
* Module's elakey
*/
private $elakey = null;

/**
* override to set module's name
*/
protected $title = null;

/**
* override to set module's icon
*/
protected $icon = '<i class="fas fa-puzzle-piece"></i>';

/**
* Action methods prefix
*/
const ACTION_PREFIX = 'action';

/**
* Add views directory to module;
*/
protected $views = null;

/**
* override to set authorized roles
*/
protected $roles = Eladmin\IAuth::ANYONE;

/**
* override to set authorized roles
*/
protected $actionRoles = [];

/**
* normalizing action names for elaActionRoles is expensive, we want to do it only once
*/
private $actionsParsed = false;

/**
* Each module has to be initialized with eladmin instance and its own elakey.
*/
public function __construct($core, $elakey) {
  $this->core = $core;
  $this->elakey = $elakey;
}

/**
* Return core instance
*/
final public function core() : Core {
  return $this->core;
}

/**
* Each module has its elakey - index in modules array - used to address requests.
*/
final public function elakey() : string {
  return $this->elakey;
}

/**
* Check if user is authorized to do action, or athorized to access module at all.
*/
final public function auth(?string $action = null) : bool {
  if ($this->core->iauth() === null)
    return true; // authorization off
  $module = $this->core->module($this->elakey());
  if ($module === null)
    return false; // user not authorized to work with the module
  $roles = $this->roles($action);
  if ($roles === Eladmin\IAuth::NOONE)
    return false;
  return $this->core->iauth()->authorize($roles);
}

/**
* Get name of the module.
*/
public function title() : string {
  return $this->title ?? class_basename(static::class);
}

/**
* Get icon of the module.
*/
public function icon() : string {
  return $this->icon;
}

/**
* Return url for this module.
*/
final public function requestUrl(?string $action = null, array $args = []) : string {
  $data['elamodule'] = $this->elakey();
  if ($action !== null) {
    $data['elaaction'] = $action;
    $data['elatoken'] = $this->core->CSRFToken();
  }
  $data = array_merge($data, $args);
  return '?' . http_build_query($data);
}

/**
* Create asset url, file path relative to /assets directory. Default $version = time()
*/
final public function assetUrl(string $path, ?string $version = null) : string {
   return $this->requestUrl(null, ['elaasset' => $path, 'ver' => $version ?? time()]);
}

/**
* Runs before any action is executed.
*/
public function prepare() : void {

}

/**
* Get roles authorized to work with the module, or specific action. Empty array means any role is authorized.
*/
final public function roles(?string $action = null) : ?array {

  if ($action === null)
    return $this->roles;

  if (!$this->actionsParsed) {
    $actionRolesCopy = (new \ArrayObject($this->actionRoles))->getArrayCopy();
    $this->actionRoles = [];
    foreach ($actionRolesCopy as $actionName => $roles) {
      $this->setRoles($roles, $actionName);
    }
    $this->actionsParsed = true;
  }

  $action = self::parseAction($action);
  return $this->actionRoles[$action] ?? IAuth::ANYONE;
}

/**
* Set roles authorized to work with the module, or specific action. Empty array means any role is authorized.
*/
private function setRoles(?array $roles, ?string $action = null) : void {
  if ($action === null) {
    $this->elaRoles = $roles;
    return;
  }

  $action = self::parseAction($action);
  $this->actionRoles[$action] = $roles;
}

/**
* Extends array of directories of views and assets.
*
* Example:
* ```lang-php
* public function views() : array {
*  return array_merge([__DIR__ . '/my_module'], parent::views());
* }
* ```
*
*/
protected function views() : array {
  $views = [];
  if (is_string($this->views)) {
    $views[] = $this->views;
  }
  $views[] = __DIR__ . '/../views/module';
  return array_merge($views, $this->core->views());
}

/**
* Return Blade instance
*/
protected function blade() : Blade {
  return $this->core->blade();
}

/**
* Return rendered view.
*/
final public function render(string $template, array $args = []) : string {
  $blade = $this->blade();
  return $blade->make($template, array_merge($args, ['eladmin' => $this->core, 'module' => $this]))->render();
}

/**
* Determinate asset content-type and render it.
*/
public function renderAsset(string $path) : void {
  $this->core->renderAsset($path);
}

/**
* Return array of all defined actions.
*/
final static public function actions() : array {
  $actions = [];
  $classMethods = get_class_methods(static::class);
  foreach ($classMethods as $classMethod) {
    if (substr($classMethod, 0, strlen(self::ACTION_PREFIX)) != self::ACTION_PREFIX ||
        !strlen(substr($classMethod, strlen(self::ACTION_PREFIX), 1)) ||
        !ctype_upper(substr($classMethod, strlen(self::ACTION_PREFIX), 1))) {
      continue;
    }
    $actions[] = self::parseAction(substr($classMethod, strlen(self::ACTION_PREFIX)));
  }
  return $actions;
}

/**
* Check if actions is defined.
*/
final static public function hasAction(string $action) : bool {
  return in_array(self::parseAction($action), static::actions());
}

/**
* Check if actions is executed.
*/
final static public function isAction(string $action) : bool {
  return $this->elakey() === $this->core->modulekey() && self::parseAction($action) === $this->core->actionkey();
}

/**
* We want action keys to be case insensitive. This converts action to lowercase.
*/
final static public function parseAction(string $action) : string {
  return strtolower($action);
}

/**
* Convinient method for plain text output. Sets HTTP header text/plain and echo $str.
*/
final static public function renderText(?string $str = null) : void {
  Header('Content-type: text/plain');
  if($str !== null)
    echo $str;
}

/**
* Convinient method for html output. Sets HTTP header text/html and echo $str.
*/
final static public function renderHtml(?string $str = null) : void {
  Header('Content-type: text/html');
  if($str !== null)
    echo $str;
}

/**
* Convinient method for json output. Sets HTTP header application/json and echo serialized $json.
*/
final static public function renderJson(?array $json = null) : void {
  Header('Content-type: application/json');
  if($json !== null)
    echo json_encode($json, JSON_UNESCAPED_UNICODE);
}

}
