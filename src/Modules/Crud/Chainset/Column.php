<?php
namespace Onspli\Eladmin\Modules\Crud\Chainset;
use \Onspli\Eladmin\Exception;
use \Onspli\Eladmin\ChainsetChild;

class Column extends ChainsetChild {

/**
* Column label.
*/
public $label = null;

/**
* Column description.
*/
public $desc = null;

/**
* Should we excape the value of the column?
*/
public $raw = false;

/**
* Should we show the column in the table?
*/
public $nonlistable = false;

/**
* Should we show the column in the edit form?
*/
public $noneditable = false;

/**
* Can we edit the value in the form?
*/
public $disabled = false;

/**
* Should we use this column for searching?
*/
public $nonsearchable = false;

/**
* Can we sort the table by this column?
*/
public $nonsortable = false;

/**
* Max length of value to be shown in the table.
*/
public $limit = 24;

/**
* Input type for the column editation.
*/
public $input = 'text';

public $listformat = null;
public $getformat = null;
public $setformat = null;
public $validate = null;
public $belongsTo = null;

/**
* Get internal name of the column.
*/
final public function getName() : string {
  return $this->_getKey();
}

  final public function getValue($row, $forEditing = false){
    $column = $this->getName();
    $value = null;

    if($this->getformat){
      $value = $this->evalProperty('getformat', $row);
    } else{
      $value = $row[$column] ?? null;
    }
    if (!$forEditing || $this->disabled){
      $value = $this->listformat ? $this->evalProperty('listformat', $row) : $value;
    }

    if($this->listformat == false && $value instanceof \Illuminate\Database\Eloquent\Model){
      if($value->elaRepresentativeColumn){
        $value = $value->{$value->elaRepresentativeColumn};
      } else{
        $value = $value->getKey();
      }
    }
    return $value;
  }

  final public function evalProperty($prop, $row){
    if (!isset($this->$prop)) return null;
    $column = $this->getName();
    if (is_callable($this->$prop))
    {
      return ($this->$prop)($row[$column] ?? null, $row, $column);
    }
    else
    {
      return $this->$prop;
    }
  }

/**
* Output raw value (i.e. HTML)
*/
public function raw() {
  $this->raw = true;
  return $this;
}

/**
* Output escaped value.
*/
public function escaped() {
  $this->raw = false;
  return $this;
}

/**
* Do not show the column in the table.
* Also ad nonsearchable and nonsortable flag.
*/
public function nonlistable() {
  $this->nonlistable = true;
  $this->nonsearchable();
  $this->nonsortable();
  return $this;
}

/**
* Show the column in the table.
*/
public function listable() {
  $this->nonlistable = false;
  return $this;
}

/**
* Do not use the column for searching.
*/
public function nonsearchable() {
  $this->nonsearchable = true;
  return $this;
}

/**
* Use the column for searching.
*/
public function searchable() {
  $this->nonsearchable = false;
  return $this;
}

/**
* Do not sort by the column.
*/
public function nonsortable() {
  $this->nonsortable = true;
  return $this;
}

/**
* Use the column for sorting.
*/
public function sortable() {
  $this->nonsortable = false;
  return $this;
}

/**
* Hide the column in the edit form.
* Also sets disabled flag.
*/
public function noneditable() {
  $this->noneditable = true;
  $this->disabled();
  return $this;
}

/**
* Show the column in the edit form.
*/
public function editable() {
  $this->noneditable = false;
  return $this;
}

/**
* Disable editing column's value.
*/
public function disabled() {
  $this->disabled = true;
  return $this;
}

/**
* Enable editing column's value.
*/
public function enabled() {
  $this->disabled = false;
  return $this;
}

/**
* Max length of value to be shown in the table.
* Doesn't have any effect on raw (unescaped) columns.
*/
public function limit(integer $len) {
  $this->listlimit = $len;
  return $this;
}

/**
* Set the type of input.
*/
public function input($type) {
  $this->input = $type;
  return $this;
}

/**
* Set the type of input to textarea.
*/
public function textarea() {
  $this->input = 'textarea';
  return $this;
}

/**
* Set the type of input to select.
*/
public function select($options = []) {
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

/**
* Shortcut for nonlistable && noneditable && disabled
*/
public function hidden() {
  $this->nonlistable();
  $this->noneditable();
  $this->disabled();
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
      throw new Exception\BadRequestException(__('Date or time format is not valid.'));
    }
  });
  return $this;
}

public function validate($func){
  $this->validate = $func;
  return $this;
}

}
