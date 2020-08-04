<?php
namespace Onspli\Eladmin\Modules\Crud\Chainset;
use \Onspli\Eladmin\Exception;
use \Onspli\Eladmin;

class Filter extends Eladmin\Chainset\Child {

  public $label = null;
  public $column = null;
  public $input = 'text';
  public $selectOptions = [];
  public $icon = '<i class="fas fa-filter"></i>';

  public function select($options){
    $this->input = 'select';
    $this->selectOptions = $options;
    return $this;
  }
}
