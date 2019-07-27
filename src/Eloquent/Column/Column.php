<?php


namespace Onspli\Eladmin\Eloquent\Column;

class Column extends \Onspli\Eladmin\Chainset\Chainset{

  public $label = null;
  public $desc = null;
  public $rawoutput = false;
  public $nonlistable = false;
  public $noneditable = false;
  public $disabled = false;

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


}
