<?php

namespace Onspli\Eladmin\Iface;

/**
 *
 */
interface Authorization
{
  /**
  * Return an array of login fields in the form of field_name=>[label=>input label, type=>input_type]
  * Retrurn null if Eladmin login dialog should be disabled.
  */
  public function elaLoginFields(): ?array;

  /**
  * Eladmin calls this method during authentication. Login Fields are passed through POST variable
  */
  public function elaLogin():void;

  /**
  * Return an array of profile fields in the form of field_name=>[label=>input label, type=>input_type]
  * Retrurn null if Eladmin edit profile dialog should be disabled.
  */
  public function elaAccountFields(): ?array;

  /**
  * Eladmin calls this method during profile update. Login Fields are passed through POST variable
  */
  public function elaAccount():void;


  /**
  * Logout.
  */
  public function elaLogout():void;

  /**
  * Authorize logged user.
  */
    public function elaAuth(?array $authorizedRoles=null):bool;
}
