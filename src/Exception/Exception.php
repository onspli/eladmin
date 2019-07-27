<?php

namespace Onspli\Eladmin\Exception;
class Exception extends \Exception{

  public function __construct($message = null, $code = 0, Exception $previous = null){
    $this->defaultProperties();
    parent::__construct($message, $code, $previous);
  }

  protected function defaultProperties(){
    $this->messages = __('Something went wrong!');
  }
}
