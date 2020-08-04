<?php
namespace Onspli\Eladmin\Modules\Crud\Chainset;
use \Onspli\Eladmin\Exception;
use \Onspli\Eladmin;

class Action extends Eladmin\Chainset\Child {

  public $label = null;
  public $nonlistable = false;
  public $noneditable = false;
  public $style = 'secondary';
  public $icon = '<i class="fas fa-play"></i>';
  public $confirm = null;
  public $done = '';
  public $bulk = null;
  public $form = false;
  public $filter = null;

  final public function getName() {
    return $this->_getKey();
  }

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

  public function hidden() {
    $this->nonlistable();
    $this->noneditable();
    return $this;
  }

  public function filter($func) {
    $this->filter = $func;
    return $this;
  }

  public function confirm($str = '') {
    if ($str === '')
      $str = __('Are you sure?');
    $this->confirm = $str;
    return $this;
  }

  public function done($js=''){
    $this->done = $js;
    return $this;
  }

  public function bulk(){
    $this->bulk = true;
    return $this;
  }

  public function nonbulk(){
    $this->bulk = null;
    return $this;
  }

  public function form(){
    $this->form = true;
    $this->noneditable();
    return $this;
  }

  public function nonform(){
    $this->form = false;
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

  public function danger(){
    $this->style = 'danger';
    return $this;
  }

  public function primary(){
    $this->style = 'primary';
    return $this;
  }

  public function secondary(){
    $this->style = 'secondary';
    return $this;
  }

  public function success(){
    $this->style = 'success';
    return $this;
  }

  public function warning(){
    $this->style = 'warning';
    return $this;
  }


}
