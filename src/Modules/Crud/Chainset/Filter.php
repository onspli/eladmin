<?php
namespace Onspli\Eladmin\Modules\Crud\Chainset;
use \Onspli\Eladmin\Exception;
use \Onspli\Eladmin\ChainsetChild;

class Filter extends ChainsetChild {

  public $label = null;
  public $column = null;
  public $input = 'text';
  public $selectOptions = [];
  public $icon = '<i class="fas fa-filter"></i>';

  public function select($options){
    $this->input = 'select';
    if(is_subclass_of($options, \Illuminate\Database\Eloquent\Model::class)){
      $this->selectOptions = function() use($options){
        $rows = $options::all();
        $ret = [''=>''];
        foreach($rows as $row) $ret[$row->getKey()] = $row->elaRepresentativeColumn?$row->{$row->elaRepresentativeColumn}:$row->getKey();
        return $ret;
      };

    } else{
      $this->selectOptions = $options;
    }


    return $this;
  }
}