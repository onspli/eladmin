<?php
namespace Onspli\Eladmin\Tests\Integration;

final class AuthenticationTest extends IntegrationTestCase {

  public function testWrongCredentialsAreRejected() : void {
    $client = $this->client();
    $response = $client->ajax(['elalogin' => 1], ['login' => self::ADMIN_LOGIN, 'password' => 'wrong']);
    $this->assertSame(401, $response->status);
    $this->assertSame(401, $this->crudRead($client, 'x')->status);
  }

  public function testLoginRegeneratesSessionId() : void {
    $client = $this->client();
    $client->get();
    $anonymousSession = $client->cookies['PHPSESSID'] ?? null;
    $this->assertNotNull($anonymousSession);

    $response = $client->post(['elalogin' => 1], ['login' => self::ADMIN_LOGIN, 'password' => self::ADMIN_PASSWORD]);
    $this->assertSame(302, $response->status);
    $this->assertNotSame($anonymousSession, $client->cookies['PHPSESSID']);

    // the fixated session id must not be authenticated
    $attacker = $this->client();
    $attacker->cookies['PHPSESSID'] = $anonymousSession;
    $this->assertSame(401, $this->crudRead($attacker, 'x')->status);
  }

  public function testLoginRegeneratesCSRFToken() : void {
    $client = $this->loggedInClient();
    $first = $this->csrfToken($client);
    $client->post(['elalogin' => 1], ['login' => self::ADMIN_LOGIN, 'password' => self::ADMIN_PASSWORD]);
    $this->assertNotSame($first, $this->csrfToken($client));
  }

  public function testSessionCookieFlags() : void {
    $response = $this->client()->get();
    $cookie = $response->header('Set-Cookie');
    $this->assertNotNull($cookie);
    $this->assertStringContainsStringIgnoringCase('HttpOnly', $cookie);
    $this->assertStringContainsStringIgnoringCase('SameSite=Lax', $cookie);
  }

  public function testStaleRequestAfterLoginKeepsUserLoggedIn() : void {
    // browser may send a request with the pre-login session id that completes after login (e.g. favicon)
    $client = $this->client();
    $client->get();
    $anonymousSession = $client->cookies['PHPSESSID'];
    $client->ajax(['elalogin' => 1], ['login' => self::ADMIN_LOGIN, 'password' => self::ADMIN_PASSWORD]);
    $token = $this->csrfToken($client);

    $stale = $this->client();
    $stale->cookies['PHPSESSID'] = $anonymousSession;
    $response = $stale->get();
    // a new session cookie would replace the authenticated one in the browser
    $this->assertNull($response->header('Set-Cookie'));
    $this->assertSame(401, $this->crudRead($stale, 'x')->status);
    $this->assertSame(200, $this->crudRead($client, $token)->status);
  }

  public function testCrossSiteLoginIsRejected() : void {
    $client = $this->client();
    $response = $client->post(['elalogin' => 1], ['login' => self::ADMIN_LOGIN, 'password' => self::ADMIN_PASSWORD], ['Sec-Fetch-Site' => 'cross-site']);
    $this->assertSame(400, $response->status);
    $this->assertSame(401, $this->crudRead($client, 'x')->status);
  }

  public function testSameSiteLoginIsAccepted() : void {
    $client = $this->client();
    $response = $client->post(['elalogin' => 1], ['login' => self::ADMIN_LOGIN, 'password' => self::ADMIN_PASSWORD], ['Sec-Fetch-Site' => 'same-origin']);
    $this->assertSame(302, $response->status);
  }

  public function testLogout() : void {
    $client = $this->loggedInClient();
    $token = $this->csrfToken($client);
    $session = $client->cookies['PHPSESSID'];

    $this->assertSame(302, $client->get(['elalogout' => 1])->status);
    $this->assertNotSame($session, $client->cookies['PHPSESSID']);
    $this->assertSame(401, $this->crudRead($client, $token)->status);
  }

  public function testVersionFooterOnlyForLoggedInUser() : void {
    $anonymous = $this->client()->get();
    $this->assertSame(200, $anonymous->status);
    $this->assertStringNotContainsString('sidebar-footer', $anonymous->body);
    $this->assertStringNotContainsString(PHP_VERSION, $anonymous->body);

    $response = $this->loggedInClient()->get(['elamodule' => 'items']);
    $this->assertSame(200, $response->status);
    $this->assertStringContainsString('sidebar-footer', $response->body);
    $this->assertStringContainsString('PHP ' . PHP_VERSION, $response->body);
  }

  public function testCrossSiteLogoutIsIgnored() : void {
    $client = $this->loggedInClient();
    $token = $this->csrfToken($client);
    $client->get(['elalogout' => 1], ['Sec-Fetch-Site' => 'cross-site']);
    $this->assertSame(200, $this->crudRead($client, $token)->status);
  }

}
