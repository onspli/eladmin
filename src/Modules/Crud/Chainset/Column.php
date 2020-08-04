<?php
namespace Onspli\Eladmin\Modules\Crud\Chainset;
use \Onspli\Eladmin\Exception;
use \Onspli\Eladmin;

class Column extends Eladmin\Chainset\Child {

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

/**
* fromat for listing
*/
public $listformat = null;

/**
* format for editing
*/
public $getformat = null;

/**
* format for updating
*/
public $setformat = null;

/**
* validation callback
*/
public $validate = null;

/**
* Get internal name of the column.
*/
final public function getName() : string {
  return $this->_getKey();
}

/**
* Extract value of the column from $row array
*/
final public function getValue(array $row, $forEditing = false) : ?string {
  $column = $this->getName();
  $value = $row[$column] ?? null;

  if (!$forEditing || $this->disabled) {
    $value = $this->listformat ? $this->evalProperty('listformat', $row) : $value;
  } else {
    $value = $this->getformat ? $this->evalProperty('getformat', $row) : $value;
  }

  return $value;
}

/**
* Eval property
*/
final public function evalProperty(string $prop, array $row) {
  if (!isset($this->$prop)) {
    return null;
  }

  $column = $this->getName();
  if (is_callable($this->$prop)) {
    return ($this->$prop)($row[$column] ?? null, $row, $column);
  } else {
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
* Set the type of input to password
* Add nonlistable flag
*/
public function password() {
  $this->input = 'password';
  $this->nonlistable();
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

/**
* Format for listing
*/
public function format($func) {
  $this->listformat = $func;
  return $this;
}

/**
* Format for editing
*/
public function get($func) {
  $this->getformat = $func;
  return $this;
}

/**
* Format user input for updating the entry
*/
public function set($func) {
  $this->setformat = $func;
  return $this;
}

/**
* Validate user input
*/
public function validate($func) {
  $this->validate = $func;
  return $this;
}

}
