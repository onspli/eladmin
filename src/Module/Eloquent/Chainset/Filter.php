<?php


namespace Onspli\Eladmin\Module\Eloquent\Chainset;

class Filter extends \Onspli\Eladmin\Chainset\Chainset{

  public $label = null;
  public $column = null;
  public $input = 'text';
  public $selectOptions = [];

  public function select($options){
    $this->input = 'select';
    if(is_subclass_of($options, \Onspli\Eladmin\Module\Eloquent\Model::class)){
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
