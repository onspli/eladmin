<?php
namespace Onspli\Eladmin\Tests\Integration;

final class CSRFTest extends IntegrationTestCase {

  public function testValidTokenIsAccepted() : void {
    $client = $this->loggedInClient();
    $this->assertSame(200, $this->crudRead($client, $this->csrfToken($client))->status);
  }

  public function testTokenFormat() : void {
    $this->assertMatchesRegularExpression('/^[0-9a-f]{64}$/', $this->csrfToken($this->loggedInClient()));
  }

  public function testTokensDifferBetweenSessions() : void {
    $this->assertNotSame($this->csrfToken($this->loggedInClient()), $this->csrfToken($this->loggedInClient()));
  }

  public function testInvalidTokenIsRejectedWithoutLogout() : void {
    $client = $this->loggedInClient();
    $token = $this->csrfToken($client);

    $response = $this->crudRead($client, 'invalid');
    $this->assertSame(401, $response->status);
    $this->assertStringContainsString('CSRF', $response->body);

    // forged requests must not be able to log the user out
    $this->assertSame(200, $this->crudRead($client, $token)->status);
  }

  public function testMissingTokenIsRejected() : void {
    $client = $this->loggedInClient();
    $this->csrfToken($client);
    $response = $client->ajax(['elamodule' => 'items', 'elaaction' => 'read']);
    $this->assertSame(401, $response->status);
  }

  public function testArrayTokenIsRejected() : void {
    $client = $this->loggedInClient();
    $this->csrfToken($client);
    $response = $client->ajax(['elamodule' => 'items', 'elaaction' => 'read', 'elatoken' => ['x']]);
    $this->assertSame(401, $response->status);
  }

  public function testTokenOfAnotherSessionIsRejected() : void {
    $victim = $this->loggedInClient();
    $attackerToken = $this->csrfToken($this->loggedInClient());
    $this->assertSame(401, $this->crudRead($victim, $attackerToken)->status);
  }

}
