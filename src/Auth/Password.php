<?php

namespace Onspli\Eladmin\Auth;
use Onspli\Eladmin\Exception;

/**
* Simple username/password authorization.
* Single user, no roles, password hash saved to file.
*/
class Password implements \Onspli\Eladmin\IAuth {
  
  // username
  protected $username = 'eladmin';
  // default password
  protected $password = 'nimdale';
  // file with current password hash
  protected $passwordFile = __DIR__ . '/../../password';
  // current password hash
  protected $passwordHash = null;
  // is passwordFile writeable?
  protected $isPasswordFileWriteable = false;

  public function __construct() {
    if (file_exists($this->passwordFile)) {
      $this->passwordHash = @file_get_contents($this->passwordFile);
      $this->isPasswordFileWriteable = is_writeable($this->passwordFile);
      return;
    }
    $this->passwordHash = password_hash($this->password, PASSWORD_DEFAULT);
    $this->isPasswordFileWriteable = file_put_contents($this->passwordFile, $this->passwordHash);
  }

  public function elaLoginFields() : ?array {
    return [
      'login' => ['label' => __('Login'), 'type' => 'text'],
      'password' => ['label' => __('Password'), 'type' => 'password']
    ];
  }

  public function elaUnauthorized() : void { }

  public function elaLogin() : void {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    if ($login == $this->username && password_verify($password , $this->passwordHash)) {
      $_SESSION['elauser'] = $this->username;
      return;
    }
    $this->elaLogout();
  }

  public function elaLogout() : void {
    $_SESSION['elauser'] = null;
  }

  public function elaAuthorize(array $authorizedRoles = []) : bool {
    return ($_SESSION['elauser'] ?? null) !== null;
  }

  public function elaUserName() : string {
    return $this->username;
  }

  public function elaAccountFields() : ?array {
    if (!$this->isPasswordFileWriteable)
      return null;
    return [
      'oldpassword' => ['label' => __('Current password'), 'type' => 'password'],
      'newpassword' => ['label' => __('New password'), 'type' => 'password'],
      'newpasswordconfirm' => ['label' => __('Confirm new password'), 'type' => 'password']
    ];
  }

  public function elaAccount() : void {
    if (!$this->isPasswordFileWriteable)
      throw new Exception(__('Cannot save new password.'));
    if (!$this->elaAuthorize())
      throw new Exception\UnauthorizedException();

    $oldpassword = $_POST['oldpassword'] ?? '';
    $newpassword = $_POST['newpassword'] ?? '';
    $newpasswordconfirm = $_POST['newpasswordconfirm'] ?? '';

    if (!password_verify($oldpassword , $this->passwordHash))
      throw new Exception\BadRequestException(__('Current password is not correct!'));
    if (!$newpassword)
      throw new Exception\BadRequestException(__('New password must not be empty!'));
    if ($newpassword != $newpasswordconfirm)
      throw new Exception\BadRequestException(__('Passwords do not match!'));

    $this->passwordHash = password_hash($newpassword, PASSWORD_DEFAULT);
    file_put_contents($this->passwordFile, $this->passwordHash);
    echo(__('Password changed.'));
  }

}
