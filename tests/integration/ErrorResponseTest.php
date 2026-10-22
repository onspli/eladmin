<?php
namespace Onspli\Eladmin\Tests\Integration;

/**
* Error messages must not reflect request data as HTML (they are rendered by browsers and toastr).
*/
final class ErrorResponseTest extends IntegrationTestCase {

  const PAYLOAD = '<script>alert(1)</script>';

  public function testUnknownModuleIsEscapedForAnonymousUser() : void {
    $response = $this->client()->get(['elamodule' => self::PAYLOAD, 'elaasset' => 'x.css']);
    $this->assertSame(400, $response->status);
    $this->assertSame('nosniff', $response->header('X-Content-Type-Options'));
    $this->assertStringNotContainsString(self::PAYLOAD, $response->body);
    $this->assertStringContainsString('&lt;script&gt;alert(1)&lt;/script&gt;', $response->body);
  }

  public function testUnknownAssetIsEscaped() : void {
    $response = $this->client()->get(['elamodule' => '', 'elaasset' => self::PAYLOAD . '.css']);
    $this->assertSame(400, $response->status);
    $this->assertStringNotContainsString(self::PAYLOAD, $response->body);
  }

  public function testUnknownActionIsEscaped() : void {
    $client = $this->loggedInClient();
    $token = $this->csrfToken($client);
    $response = $client->ajax(['elamodule' => 'items', 'elaaction' => self::PAYLOAD, 'elatoken' => $token]);
    $this->assertSame(400, $response->status);
    $this->assertStringNotContainsString(self::PAYLOAD, $response->body);
  }

  public function testInternalExceptionMessageIsEscaped() : void {
    $client = $this->loggedInClient();
    $token = $this->csrfToken($client);
    $response = $client->ajax(['elamodule' => 'items', 'elaaction' => 'fail', 'elatoken' => $token]);
    $this->assertSame(500, $response->status);
    $this->assertSame('nosniff', $response->header('X-Content-Type-Options'));
    $this->assertSame('&lt;b&gt;internal&lt;/b&gt;', $response->body);
  }

}
