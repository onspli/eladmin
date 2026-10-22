<?php
namespace Onspli\Eladmin\Tests\Integration;

use PHPUnit\Framework\Attributes\DataProvider;

final class CrudReadTest extends IntegrationTestCase {

  public static function sortByProvider() : array {
    // see fixture for the row order of each column
    return [
      'primary key' => ['id', [1, 2, 3]],
      'listable sortable column' => ['name', [3, 1, 2]],
      'nonlistable column set as default' => ['rank', [1, 3, 2]],
      'hidden column falls back to primary key' => ['secret', [1, 2, 3]],
      'unknown column falls back to primary key' => ['unknown', [1, 2, 3]],
      'json path falls back to primary key' => ['name->a', [1, 2, 3]],
      'empty falls back to primary key' => ['', [1, 2, 3]],
    ];
  }

  #[DataProvider('sortByProvider')]
  public function testSortBy(string $sortBy, array $expectedIds) : void {
    $client = $this->loggedInClient();
    $response = $this->crudRead($client, $this->csrfToken($client), ['sortBy' => $sortBy, 'direction' => 'asc']);
    $this->assertSame(200, $response->status, $response->body);
    $this->assertSame($expectedIds, $response->json()['ids']);
  }

  public function testInvalidDirectionFallsBackToDescending() : void {
    $client = $this->loggedInClient();
    $response = $this->crudRead($client, $this->csrfToken($client), ['sortBy' => 'id', 'direction' => 'asc; drop table items']);
    $this->assertSame([3, 2, 1], $response->json()['ids']);
  }

  public function testHiddenColumnIsNotListed() : void {
    $client = $this->loggedInClient();
    $rows = $this->crudRead($client, $this->csrfToken($client), ['sortBy' => 'id'])->json()['rows'];
    foreach ($rows as $row)
      $this->assertNotContains('x', $row);
  }

  public function testPagingIsSanitized() : void {
    $client = $this->loggedInClient();
    $response = $this->crudRead($client, $this->csrfToken($client), ['sortBy' => 'id', 'page' => -5, 'resultsPerPage' => 2]);
    $this->assertSame(200, $response->status);
    $this->assertSame([1, 2], $response->json()['ids']);
    $this->assertSame(3, $response->json()['totalResults']);
  }

}
