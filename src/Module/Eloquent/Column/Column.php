<?php


namespace Onspli\Eladmin\Module\Eloquent\Column;

class Column extends \Onspli\Eladmin\Chainset\Chainset{

  public $label = null;
  public $desc = null;
  public $rawoutput = false;
  public $nonlistable = false;
  public $noneditable = false;
  public $disabled = false;
  public $input = 'text';
  public $listformat = null;
  public $realcolumn = false;
  public $listlimit = 10;

  public function raw(){
    $this->rawoutput = true;
    return $this;
  }

  public function escaped(){
    $this->rawoutput = false;
    return $this;
  }

  public function nonlistable(){
    $this->nonlistable = true;
    return $this;
  }

  public function listable(){
    $this->nonlistable = false;
    return $this;
  }

  public function noneditable(){
    $this->noneditable = true;
    return $this;
  }

  public function editable(){
    $this->noneditable = false;
    return $this;
  }

  public function disabled(){
    $this->disabled = true;
    return $this;
  }

  public function enabled(){
    $this->disabled = false;
    return $this;
  }

  public function input($type){
    $this->input = $type;
    return $this;
  }

  public function textarea(){
    $this->input = 'textarea';
    return $this;
  }

  public function select($options){
    $this->input = 'select';
    $this->selectOptions = $options;
    return $this;
  }

  public function selectFromModel($model, $desc){
    $this->input = 'selectFromModel';
    $this->selectFromModel = $model;
    $this->selectFromModelDesc = $desc;
    $this->listformat(function($val) use ($model, $desc){
      $entry = $model::find($val);
      if(!$entry) return $val;
      return $entry->$desc;
    });
    return $this;
  }

  public function format($func){
    $this->listformat = $func;
    return $this;
  }

  public function limit($len){
    $this->listlimit = $len;
    return $this;
  }


}
