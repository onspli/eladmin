<?php
namespace Onspli\Eladmin\Exception;

/**
* Invalid CSRF token. Unlike other unauthorized exceptions it doesn't log the user out,
* otherwise any cross-site request would be able to log the user out.
*/
class CSRFException extends UnauthorizedException {

  public function __construct (string $message = '', int $code = 0, ?\Throwable $previous = null) {
    if (!$message)
      $message = __("CSRF token not valid! Try reloading page.");
    parent::__construct($message, $code, $previous);
  }

}
