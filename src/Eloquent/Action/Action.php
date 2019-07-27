<?php


namespace Onspli\Eladmin\Eloquent\Action;

class Action extends \Onspli\Eladmin\Chainset\Chainset{

  public $label = null;
  public $nonlistable = true;
  public $noneditable = false;
  public $style = 'secondary';
  public $icon = '';

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
