<?php

namespace Onspli\Eladmin\Module;
use \Onspli\Eladmin\Exception;


class Module implements \Onspli\Eladmin\Iface\Module
{

  protected $elaTitle = null;
  protected $elaIcon = '<i class="fas fa-puzzle-piece"></i>';

  public $bladeViewRender = 'modules.module.render';

  protected $elaAuthorizedRoles = [];
  protected $elaAuthorizedRolesForLowercaseActions = [];

  public $eladmin = null;
  public $elakey = null;

  protected function defaultProperties(){
  }

  public function elakey(){
    return (string)$this->elakey;
  }

  public function __toString(){
    return $this->elakey();
  }

  public function elaAuth($action): bool{
    return $this->eladmin->auth($action, $this);
  }

  public function __construct(){
    $this->defaultProperties();
  }

  public function elaGetTitle(): string {
    if($this->elaTitle) return $this->elaTitle;
    else return static::class;
  }

  public function elaGetIcon(): string {
    return $this->elaIcon;
  }

  public function elaGetAuthorizedRoles(): array{
    return $this->elaAuthorizedRoles;
  }

  public function elaGetAuthorizedRolesActions(): array{
    return $this->elaAuthorizedRolesForLowercaseActions;
  }

  public function elaRequest($action, $args=[]){
    return $this->eladmin->request($action, $this, $args);
  }

}
