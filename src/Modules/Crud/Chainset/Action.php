<?php
namespace Onspli\Eladmin\Modules\Crud\Chainset;
use \Onspli\Eladmin\Exception;
use \Onspli\Eladmin;

class Action extends Eladmin\Chainset\Child {

  public $label = null;
  public $nonlistable = true;
  public $noneditable = false;
  public $style = 'secondary';
  public $icon = '';
  public $confirm = null;
  public $done = '';
  public $bulk = null;

  final public function getModule() {
    return $this->_getParent()->getModule();
  }

  final public function getName() {
    return $this->_getKey();
  }

  final public function evalProperty($prop, $row) {
    if (!isset($this->$prop))
      return null;
    if (is_callable($this->$prop)) {
      // we pass second argument for backward compatibility
      return ($this->$prop)($row, $row);
    } else {
      return $this->$prop;
    }
  }

  final public function getAction($row) {
    $action = [
      'action' => $this->getName(),
      'done' => $this->done,
      'id' => $row[$this->getModule()->elaPrimary()],
      'style' => $this->style,
      'icon' => $this->icon,
      'module' => $this->getModule()->elakey()
    ];

    if (isset($this->label)) {
      $action['label'] = $this->evalProperty('label', $row);
    } else if (!$this->icon) {
      $action['label'] = $this->getName();
    }

    if (isset($this->title)) {
      $action['title'] = $this->evalProperty('title', $row);
    }
    if (isset($this->confirm)) {
      $action['confirm'] = $this->evalProperty('confirm', $row);
    }
    return $action;
  }

  public function hidden() {
    $this->nonlistable();
    $this->noneditable();
    return $this;
  }

  public function confirm($str = '') {
    if ($str === '')
      $str = __('Are you sure?');
    $this->confirm = $str;
    return $this;
  }

  public function auth($roles){
    $this->getModule()->elaSetRoles($roles, $this->getName());
    return $this;
  }

  public function done($js=''){
    $this->done = $js;
    return $this;
  }

  public function bulk($bulk=''){
    if ($bulk === '') $bulk = $this->getName();
    $this->bulk = $bulk;
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
