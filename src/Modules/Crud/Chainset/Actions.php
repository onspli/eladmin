<?php
namespace Onspli\Eladmin\Modules\Crud\Chainset;
use \Onspli\Eladmin\Exception;
use \Onspli\Eladmin\ChainsetParent;

class Actions extends ChainsetParent {

protected $childClass = Action::class;

private $module = null;

final public function setModule($module) {
  $this->module = $module;
}

final public function getModule() {
  return $this->module;
}

}
