<?php

namespace Onspli\Eladmin;

interface IAuth {

  /**
  * Noone can access.
  */
  const NOONE = null;

  /**
  * Anyone can access.
  */
  const ANYONE = [];

  /**
  * Return an array of login fields in the form of field_name=>[label=>input label, type=>input_type]
  * Retrurn null if Eladmin login dialog should be disabled (and you want to do authentication on your own)
  */
  public function loginFields() : ?array;

  /**
  * This method is called when user is not autorized and loginFileds returns null.
  * You can redirect to your own login page. Or leave it empty to show HTTP 401.
  */
  public function unauthorized() : void;

  /**
  * Eladmin calls this method during authentication.
  */
  public function login(array $fields) : void;

  /**
  * Return an array of profile fields in the form of field_name=>[label=>input label, type=>input_type]
  * Retrurn null if Eladmin edit profile dialog should be disabled.
  */
  public function accountFields() : ?array;

  /**
  * Eladmin calls this method during profile update.
  */
  public function accountUpdate(array $fileds) : void;

  /**
  * Logout.
  */
  public function logout() : void;

  /**
  * Check if user is logged in. Also check if user has one of the $authorizedRoles (if specified).
  */
  public function authorize(array $authorizedRoles = self::ANYONE) : bool;

  /**
  * Get user's name to show it in admin.
  */
  public function userName() : string;

}
