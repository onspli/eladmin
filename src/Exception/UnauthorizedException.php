<?php
namespace Onspli\Eladmin\Exception;

class UnauthorizedException extends Exception {

  public function __construct (string $message = '', int $code = 0, Throwable $previous = NULL) {
    if (!$message)
      $message = __('Unauthorized access!');
    parent::__construct($message, $code, $previous);
  }

}
