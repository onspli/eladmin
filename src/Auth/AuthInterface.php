<?php

namespace Onspli\Eladmin\Auth;

interface AuthInterface
{
  /**
  * Return an array of login fields in the form of field_name=>[label=>input label, type=>input_type]
  * Retrurn null if Eladmin login dialog should be disabled (and you want to do authentication on your own)
  */
  public function elaLoginFields() : ?array;

  /**
  * This method is called when user is not autorized and elaLoginFileds returns null.
  * You can redirect to your own login page. Or leave it empty to show HTTP 401.
  */
  public function elaUnauthorized() : void;

  /**
  * Eladmin calls this method during authentication. Login Fields are passed through POST variable
  */
  public function elaLogin() : void;

  /**
  * Return an array of profile fields in the form of field_name=>[label=>input label, type=>input_type]
  * Retrurn null if Eladmin edit profile dialog should be disabled.
  */
  public function elaAccountFields() : ?array;

  /**
  * Eladmin calls this method during profile update. Login Fields are passed through POST variable
  */
  public function elaAccount() : void;

  /**
  * Logout.
  */
  public function elaLogout() : void;

  /**
  * Check if user is logged in. Also check if user has one of the $authorizedRoles (if specified).
  * Empty array means any role.
  */
  public function elaAuthorize(array $authorizedRoles = []) : bool;

  /**
  * Get user's name to show it in admin.
  */
  public function elaUserName() : string;

}
