<?php


namespace Onspli\Eladmin\Module\Eloquent\Chainset;
use \Onspli\Eladmin;

class Column extends Eladmin\Chainset\Chainset{

  public $label = null;
  public $desc = null;
  public $rawoutput = false;
  public $nonlistable = false;
  public $noneditable = false;
  public $disabled = false;
  public $input = 'text';
  public $listformat = null;
  public $realcolumn = false;
  public $listlimit = 24;
  public $belongsTo = null;
  public $getformat = null;
  public $setformat = null;
  public $validate = null;

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

  public function get($func){
    $this->getformat = $func;
    return $this;
  }

  public function set($func){
    $this->setformat = $func;
    return $this;
  }

  public function datetime($format){
    $this->get(function($val, $row) use($format){
      $carbon = \Carbon\Carbon::parse($val);
      if($carbon->year < 1) return '';
      return $carbon->format($format);
    });
    $this->set(function($val) use($format){
      if(!$val) return 0;
      try{
        return \Carbon\Carbon::createFromFormat($format, $val);
      } catch(\Exception $e){
        throw new Eladmin\Exception\BadRequestException(__('Date or time format is not valid.'));
      }
    });
    return $this;
  }

  public function validate($func){
    $this->validate = $func;
    return $this;
  }


}
