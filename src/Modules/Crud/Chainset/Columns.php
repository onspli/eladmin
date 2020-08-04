<?php
namespace Onspli\Eladmin\Modules\Crud\Chainset;
use \Onspli\Eladmin\Exception;
use \Onspli\Eladmin;

class Columns extends Eladmin\Chainset\Chainset {

protected $childClass = Column::class;

/**
* generate array of actions for one column
*/
public function getConfig() {
  $config = [];
  foreach($this as $column) {
    if (!$column->listable)
      continue;
    $configArr = [];
    if (!$column->raw) {
      $configArr["limit"] = $column->limit;
    } else {
      $configArr["raw"] = 1;
    }
    $config[] = $configArr;
  }
  return $config;
}

}
