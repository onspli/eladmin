<?php

namespace Onspli\Eladmin\Exception;
class BadRequestException extends Exception{
  protected function defaultProperties(){
    parent::defaultProperties();
    $this->messages = __('Invalid arguments!');
  }
}
