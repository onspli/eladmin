<?php
namespace Onspli\Eladmin\Modules\Crud\Chainset;
use \Onspli\Eladmin\Exception;
use \Onspli\Eladmin;

class Actions extends Eladmin\Chainset\Chainset {

protected $childClass = Action::class;

private $module = null;

final public function setModule($module) {
  $this->module = $module;
}

final public function getModule() {
  return $this->module;
}

public function __isset($key) {
  $key = Eladmin\Eladmin::normalizeActionName($key);
  return parent::__isset($key);
}

public function __unset($key) {
  $key = Eladmin\Eladmin::normalizeActionName($key);
  parent::__unset($key);
}

public function __get($key) {
  $key = Eladmin\Eladmin::normalizeActionName($key);
  return parent::__get($key);
}

}
