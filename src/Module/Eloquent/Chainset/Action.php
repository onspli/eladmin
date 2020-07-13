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
  public $bulk = null;

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

  final public function getName(){
    if ($this->_get_parent() === null) throw new \Exception("Cannot get name of parent of actions.");
    return $this->_get_key();
  }

  final public function evalProperty($prop, $row){
    if ($this->_get_parent() === null) throw new \Exception("Cannot eval properties of parent of actions.");
    if (!isset($this->$prop)) return null;
    if (is_callable($this->$prop))
    {
      // we pass second argument for backward compatibility
      return ($this->$prop)($row, $row);
    }
    else
    {
      return $this->$prop;
    }
  }

  final public function getAction($row){
    $action = [
      'action' => $this->getName(),
      'done' => $this->done,
      'id' => $row->getKey(),
      'style' => $this->style,
      'icon' => $this->icon,
      'module' => $this->_get_module()->elakey()
    ];

    if(isset($this->label)){
      $action['label'] = $this->evalProperty('label', $row);
    } else if(!$this->icon){
      $action['label'] = $this->getName();
    }

    if(isset($this->title)){
      $action['title'] = $this->evalProperty('title', $row);
    }
    if(isset($this->confirm)){
      $action['confirm'] = $this->evalProperty('confirm', $row);
    }
    return $action;
  }

  public function hidden(){
    $this->nonlistable();
    $this->noneditable();
    return $this;
  }

  public function confirm($str=''){
    if ($str === '') $str = __('Are you sure?');
    $this->confirm = $str;
    return $this;
  }

  public function auth($roles){
    $this->_get_module()->elaSetAuthorizedRolesAction($this->_get_key(), $roles);
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
