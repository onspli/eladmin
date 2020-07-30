<?php
use PHPUnit\Framework\TestCase;
use Onspli\Eladmin;

class TModule extends Eladmin\Module {
function __construct() {

}
}

class ModuleRoles extends TModule {
  protected $roles = ['admin'];
  protected $actionRoles = [ 'Read' => ['admin', 'user']];
}

final class ModuleTest extends TestCase {

  public function testDefaultRoles() : void {
    $module = new TModule();
    $this->assertEquals([], $module->roles());
    $this->assertEquals([], $module->roles('read'));
  }

  public function testRoles() : void {
    $module = new ModuleRoles();
    $this->assertEquals(['admin'], $module->roles());
    $this->assertEquals(['admin', 'user'], $module->roles('read'));
    $this->assertEquals(['admin', 'user'], $module->roles('Read'));
    $this->assertEquals(['admin', 'user'], $module->roles('ReaD'));
    $this->assertEquals([], $module->roles('write'));
  }

}
