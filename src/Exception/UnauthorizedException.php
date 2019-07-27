<?php

namespace Onspli\Eladmin\Exception;
class UnauthorizedException extends Exception{
  protected function defaultProperties(){
    parent::defaultProperties();
    $this->messages = __('Unauthorized access!');
  }
}
