<?php

namespace Onspli\Eladmin\Iface;

interface Module{

  public function elaGetTitle(): string;
  public function elaGetFasIcon(): string;
  public function elaGetJs(): string;
  public function elaGetAuthorizedRoles(): array;

}
