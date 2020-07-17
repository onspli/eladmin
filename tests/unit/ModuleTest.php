<?php
use PHPUnit\Framework\TestCase;
use Onspli\Eladmin\Module;

class ModuleA {
  use Module;
  protected $elaRoles = ['admin'];
  protected $elaActionRoles = [ 'Read' => ['admin', 'user']];
}

class ModuleB {
  use Module;
}

final class ModuleTest extends TestCase {

  public function testRoles() : void {
    $module = new ModuleA();
    $this->assertEquals(['admin'], $module->elaGetRoles());
    $this->assertEquals(['admin', 'user'], $module->elaGetRoles('read'));
    $this->assertEquals(['admin', 'user'], $module->elaGetRoles('Read'));
    $this->assertEquals(['admin', 'user'], $module->elaGetRoles('ReaD'));

    $module->elaSetRoles([], 'REad');
    $this->assertEquals([], $module->elaGetRoles('read'));
    $this->assertEquals([], $module->elaGetRoles('write'));

    $module->elaSetRoles(['moderator', 'admin'], 'wRite');
    $this->assertEquals(['moderator', 'admin'], $module->elaGetRoles('wriTe'));

    $module->elaSetRoles(['moderator']);
    $this->assertEquals(['moderator'], $module->elaGetRoles());
  }

  public function testDefaultRoles() : void {
    $module = new ModuleB();
    $this->assertEquals([], $module->elaGetRoles());
    $this->assertEquals([], $module->elaGetRoles('read'));

    $module->elaSetRoles(['moderator', 'admin'], 'wRite');
    $this->assertEquals(['moderator', 'admin'], $module->elaGetRoles('wriTe'));
  }

}
