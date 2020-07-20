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
    $this->assertEquals(['admin'], $module->elaRoles());
    $this->assertEquals(['admin', 'user'], $module->elaRoles('read'));
    $this->assertEquals(['admin', 'user'], $module->elaRoles('Read'));
    $this->assertEquals(['admin', 'user'], $module->elaRoles('ReaD'));

    $module->elaSetRoles([], 'REad');
    $this->assertEquals([], $module->elaRoles('read'));
    $this->assertEquals([], $module->elaRoles('write'));

    $module->elaSetRoles(['moderator', 'admin'], 'wRite');
    $this->assertEquals(['moderator', 'admin'], $module->elaRoles('wriTe'));

    $module->elaSetRoles(['moderator']);
    $this->assertEquals(['moderator'], $module->elaRoles());
  }

  public function testDefaultRoles() : void {
    $module = new ModuleB();
    $this->assertEquals([], $module->elaRoles());
    $this->assertEquals([], $module->elaRoles('read'));

    $module->elaSetRoles(['moderator', 'admin'], 'wRite');
    $this->assertEquals(['moderator', 'admin'], $module->elaRoles('wriTe'));
  }

}
