<?php

namespace Onspli\Eladmin\Iface;

interface Module{


  public function elaGetTitle(): string;

  public function elaGetIcon(): string;

  public function elaGetAuthorizedRoles(): array;

  public function elaGetAuthorizedRolesActions(): array;

  public function elakey();

  public function __toString();

  public function elaAuth($action): bool;


}
