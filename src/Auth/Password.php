<?php

namespace Onspli\Eladmin\Auth;
use Onspli\Eladmin;

/**
* Simple username/password authorization.
* Single user, no roles, password hash saved to file.
*/
class Password implements Eladmin\IAuth {

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

  public function loginFields() : ?array {
    return [
      'login' => ['label' => __('Login'), 'type' => 'text'],
      'password' => ['label' => __('Password'), 'type' => 'password']
    ];
  }

  public function unauthorized() : void { }

  public function login($fields) : void {
    $login = $fields['login'];
    $password = $fields['password'];
    if ($login == $this->username && password_verify($password , $this->passwordHash)) {
      $_SESSION['elauser'] = $this->username;
      return;
    }
    $this->logout();
  }

  public function logout() : void {
    $_SESSION['elauser'] = null;
  }

  public function authorize(array $authorizedRoles = []) : bool {
    return ($_SESSION['elauser'] ?? null) !== null;
  }

  public function userName() : string {
    return $this->username;
  }

  public function accountFields() : ?array {
    if (!$this->isPasswordFileWriteable)
      return null;
    return [
      'oldpassword' => ['label' => __('Current password'), 'type' => 'password'],
      'newpassword' => ['label' => __('New password'), 'type' => 'password'],
      'newpasswordconfirm' => ['label' => __('Confirm new password'), 'type' => 'password']
    ];
  }

  public function accountUpdate($fields) : void {
    if (!$this->isPasswordFileWriteable)
      throw new Eladmin\Exception(__('Cannot save new password.'));
    if (!$this->authorize())
      throw new Eladmin\Exception\UnauthorizedException();

    $oldpassword = $fields['oldpassword'];
    $newpassword = $fields['newpassword'];
    $newpasswordconfirm = $fields['newpasswordconfirm'];

    if (!password_verify($oldpassword , $this->passwordHash))
      throw new Eladmin\Exception\BadRequestException(__('Current password is not correct!'));
    if (!$newpassword)
      throw new Eladmin\Exception\BadRequestException(__('New password must not be empty!'));
    if ($newpassword != $newpasswordconfirm)
      throw new Eladmin\Exception\BadRequestException(__('Passwords do not match!'));

    $this->passwordHash = password_hash($newpassword, PASSWORD_DEFAULT);
    file_put_contents($this->passwordFile, $this->passwordHash);
    echo(__('Password changed.'));
  }

}
