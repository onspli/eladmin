<?php


namespace Onspli\Eladmin\Module\Eloquent\Chainset;

class Action extends \Onspli\Eladmin\Chainset\Chainset{

  public $label = null;
  public $nonlistable = true;
  public $noneditable = false;
  public $style = 'secondary';
  public $icon = '';
  public $confirm = null;
  public $done = '';

  private $module = null;
  final public function _set_module($module)
  {
    $this->module = $module;
  }

  final public function _get_module()
  {
    $parent = $this->_get_parent();
    if ($parent === null) return $this->module;
    else return $parent->_get_module();
  }


  public function confirm($str=''){
    $this->confirm = $str;
    return $this;
  }

  public function auth($role){
    $this->_get_module()->elaSetAuthorizedRolesAction($this->_get_key(), $role);
  }

  public function done($js=''){
    $this->done = $js;
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
