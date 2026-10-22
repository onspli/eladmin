<?php
namespace Onspli\Eladmin\Tests\Integration;

/**
* EloquentUser auth module. Fixture seeds user 'victim' with id 2.
*/
final class UserModuleTest extends IntegrationTestCase {

  const VICTIM_ID = 2;

  public function testAuthorizedDeleteRequiresPassword() : void {
    $client = $this->loggedInClient();
    $token = $this->csrfToken($client);
    $query = ['elamodule' => 'elaauth', 'elaaction' => 'authorizedDelete', 'id' => self::VICTIM_ID, 'elatoken' => $token];

    $response = $client->ajax($query);
    $this->assertSame(400, $response->status);
    $this->assertTrue($this->userExists(self::VICTIM_ID));

    $response = $client->ajax($query, ['authpassword' => 'wrong']);
    $this->assertSame(400, $response->status);
    $this->assertTrue($this->userExists(self::VICTIM_ID));

    $response = $client->ajax($query, ['authpassword' => self::ADMIN_PASSWORD]);
    $this->assertSame(200, $response->status, $response->body);
    $this->assertFalse($this->userExists(self::VICTIM_ID));
  }

  public function testPlainDeleteIsDisabled() : void {
    $client = $this->loggedInClient();
    $token = $this->csrfToken($client);
    $response = $client->ajax(['elamodule' => 'elaauth', 'elaaction' => 'delete', 'id' => 1, 'elatoken' => $token]);
    $this->assertSame(401, $response->status);
    $this->assertTrue($this->userExists(1));
  }

  public function testUserModuleRequiresAdminRole() : void {
    $client = $this->loggedInClient('editor', 'editorpassword');
    $token = $this->csrfToken($client);
    $this->assertSame(200, $this->crudRead($client, $token)->status);
    $this->assertSame(401, $this->crudRead($client, $token, [], 'elaauth')->status);
  }

  public function testUserModulePageRequiresAdminRole() : void {
    $client = $this->loggedInClient('editor', 'editorpassword');
    $this->assertSame(302, $client->get(['elamodule' => 'elaauth'])->status);
    // user is redirected, not logged out
    $this->assertSame(200, $this->crudRead($client, $this->csrfToken($client))->status);
  }

  private function userExists(int $id) : bool {
    $statement = $this->db()->prepare('SELECT COUNT(*) FROM elausers WHERE id = ?');
    $statement->execute([$id]);
    return $statement->fetchColumn() > 0;
  }

}
