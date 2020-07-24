<?php
namespace Onspli\Eladmin\Exception;

class Exception extends \Exception {

  public function __construct (string $message = '', int $code = 0, Throwable $previous = NULL) {
    if (!$message)
      $message = __('Something went wrong!');
    parent::__construct($message, $code, $previous);
  }
  
}
