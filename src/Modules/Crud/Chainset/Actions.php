<?php
namespace Onspli\Eladmin\Modules\Crud\Chainset;
use \Onspli\Eladmin\Exception;
use \Onspli\Eladmin;

class Actions extends Eladmin\Chainset\Chainset {

protected $childClass = Action::class;

public function __isset($key) {
  $key = Eladmin\Module::parseAction($key);
  return parent::__isset($key);
}

public function __unset($key) {
  $key = Eladmin\Module::parseAction($key);
  parent::__unset($key);
}

public function __get($key) {
  $key = Eladmin\Module::parseAction($key);
  return parent::__get($key);
}

}
