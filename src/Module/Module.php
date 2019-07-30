<?php

namespace Onspli\Eladmin\Module;
use \Onspli\Eladmin;
use \Onspli\Eladmin\Exception;


trait Module
{

  protected $eladmin = null;
  protected $elakey = null;

  public function elaInit($eladmin, $elakey){
    $this->eladmin = $eladmin;
    $this->elakey = $elakey;
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

  public function elaGetTitle(): string {
    return $this->elaTitle??class_basename(static::class);
  }

  public function elaGetIcon(): string {
    return $this->elaIcon??'<i class="fas fa-puzzle-piece"></i>';
  }

  public function elaGetAuthorizedRoles(): array{
    return $this->elaAuthorizedRoles??[];
  }

  public function elaGetAuthorizedRolesActions(): array{
    $authRoles = $this->elaAuthorizedRolesActions??[];
    $arr = [];
    foreach($authRoles as $action=>$data)
    $arr[mb_strtolower($action)] = $data;
    return $arr;

  }

  public function elaRequest($action, $args=[]){
    return $this->eladmin->request($action, $this, $args);
  }

  protected function elaViewsDef(): array{
    return [
      'render'=>'modules.module.render'
    ];
  }

  public function elaGetView($key): string{
    return ($this->elaViews??$this->elaViewsDef())[$key];
  }

}
