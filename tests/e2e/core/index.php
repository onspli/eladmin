<?php
require_once __DIR__ . '/../EladminTest.php';

class TestModule {
  use Onspli\Eladmin\Module;
}

class MyEladmin extends EladminTest {
  protected $views = __DIR__;

  protected $modules = [TestModule::class];
}

$eladmin = new MyEladmin();
$eladmin->run();
