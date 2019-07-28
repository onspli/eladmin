<?php


namespace Onspli\Eladmin\Module\Eloquent\Chainset;

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
  public $belongsTo = null;

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

  public function select($options=[]){
    $this->input = 'select';
    $this->selectOptions = $options;
    // args: $value, $row, $column, $module, $eladmin
    if(!sizeof($options) && $this->belongsTo){
      $model = $this->belongsTo;
      $this->selectOptions = function() use ($model) {
        $rows = $model::all();
        $arr = [];
        foreach($rows as $row){
          if($row->elaRepresentativeColumn)
            $arr[$row->getKey()] = $row->{$row->elaRepresentativeColumn};
          else
            $arr[$row->getKey()] = $row->getKey();
        }
        return $arr;
      };
    }
    return $this;
  }

  public function belongsTo($model){
    if(!is_subclass_of($model, \Onspli\Eladmin\Module\Eloquent\Model::class))
      throw new \Exception('Column can only be a subclass of \Onspli\Eladmin\Module\Eloquent\Model');
    $this->belongsTo = $model;

    $this->listformat(function($val) use ($model){
      $entry = $model::find($val);
      if(!$entry || !$entry->elaRepresentativeColumn) return $val;
      return $entry->{$entry->elaRepresentativeColumn};
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
