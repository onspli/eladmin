<?php
namespace Onspli\Eladmin\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Onspli\Eladmin;
use Onspli\Eladmin\Exception;

final class CoreTest extends TestCase {

  protected function setUp() : void {
    // exceptions translate their default messages with __()
    (new \Gettext\Translator())->register();
    $_SESSION = [];
  }

  public function testCSRFTokenIsLongRandomHex() : void {
    $token = (new Eladmin\Core([]))->CSRFToken();
    $this->assertMatchesRegularExpression('/^[0-9a-f]{64}$/', $token);
  }

  public function testCSRFTokenIsStableWithinSession() : void {
    $core = new Eladmin\Core([]);
    $this->assertSame($core->CSRFToken(), $core->CSRFToken());
    $this->assertSame($_SESSION['elacsrftoken'], $core->CSRFToken());
  }

  public function testCSRFTokenDiffersBetweenSessions() : void {
    $first = (new Eladmin\Core([]))->CSRFToken();
    $_SESSION = [];
    $second = (new Eladmin\Core([]))->CSRFToken();
    $this->assertNotSame($first, $second);
  }

  public function testCSRFTokenKeepsExistingSessionToken() : void {
    // sessions created by previous versions keep working
    $_SESSION['elacsrftoken'] = 'legacyToken12345';
    $this->assertSame('legacyToken12345', (new Eladmin\Core([]))->CSRFToken());
  }

  public function testCSRFExceptionIsUnauthorizedException() : void {
    $e = new Exception\CSRFException();
    $this->assertInstanceOf(Exception\UnauthorizedException::class, $e);
    $this->assertSame('CSRF token not valid! Try reloading page.', $e->getMessage());
  }

}
