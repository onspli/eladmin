<?php
namespace Onspli\Eladmin\Modules\Crud\Chainset;
use \Onspli\Eladmin\Exception;
use \Onspli\Eladmin;

class Action extends Eladmin\Chainset\Child {

/**
* Action label.
*/
public $label = null;

/**
* Show action in crud table.
*/
public $listable = true;

/**
* Show action in edit form.
*/
public $editable = true;

/**
* Action style.
*/
public $style = 'secondary';

/**
* Action icon
*/
public $icon = '<i class="fas fa-play"></i>';

/**
* Confirmation question string.
*/
public $confirm = null;

/**
* JS code to be executed when action ends successfully.
*/
public $done = '';

/**
* Enable as bulk action.
*/
public $bulk = null;

/**
* Improper action - it generates form.
*/
public $form = false;

/**
* Callback to determinate if the action should be visible for a particular item.
*/
public $filter = null;

/**
* Get normalized name of action
*/
final public function getName() {
  return $this->_getKey();
}

/**
*
*/
final public function getAction() {
  $action = [
    'done' => $this->done,
    'label' => $this->label ?? ucfirst($this->getName()),
    'style' => $this->style,
    'icon' => $this->icon,
    'form' => $this->form
  ];

  if (isset($this->title)) {
    $action['title'] = $this->title;
  }
  if (isset($this->confirm)) {
    $action['confirm'] = $this->confirm;
  }
  return $action;
}

/**
* Shortcut for nonlistable && noneditable
*/
public function hidden() {
  $this->nonlistable();
  $this->noneditable();
  return $this;
}

/**
* Filter.
*/
public function filter($func) {
  $this->filter = $func;
  return $this;
}

/**
* Confirm.
*/
public function confirm($str = '') {
  if ($str === '')
    $str = __('Are you sure?');
  $this->confirm = $str;
  return $this;
}

/**
* JS to be done after action.
*/
public function done($js=''){
  $this->done = $js;
  return $this;
}

/**
* Bulk action
*/
public function bulk(){
  $this->bulk = true;
  return $this;
}

/**
* Not a bulk action
*/
public function nonbulk(){
  $this->bulk = null;
  return $this;
}

/**
* Form action.
* Also adds noneditable - cannot show form when edit form already shown.
*/
public function form(){
  $this->form = true;
  $this->noneditable();
  return $this;
}

/**
* Not form action
*/
public function nonform(){
  $this->form = false;
  return $this;
}

/**
* Do not show in crud table
*/
public function nonlistable(){
  $this->listable = false;
  return $this;
}

/**
* Show in crud table
*/
public function listable(){
  $this->listable = true;
  return $this;
}

/**
* Do not show in edit form
*/
public function noneditable(){
  $this->editable = false;
  return $this;
}

/**
* Show in edit form
*/
public function editable(){
  $this->editable = true;
  return $this;
}

/**
* Style - danger
*/
public function danger(){
  $this->style = 'danger';
  return $this;
}

/**
* Style - primary
*/
public function primary(){
  $this->style = 'primary';
  return $this;
}

/**
* Style . secondary
*/
public function secondary(){
  $this->style = 'secondary';
  return $this;
}

/**
* Style - success
*/
public function success(){
  $this->style = 'success';
  return $this;
}

/**
* Style - warning
*/
public function warning(){
  $this->style = 'warning';
  return $this;
}

}
