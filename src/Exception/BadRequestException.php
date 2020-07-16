<?php
namespace Onspli\Eladmin\Exception;

class BadRequestException extends Exception {

  public function __construct (string $message = '', int $code = 0, Throwable $previous = NULL) {
    if (!$message)
      $message = __('Invalid arguments!');
    parent::__construct($message, $code, $previous);
  }

}
