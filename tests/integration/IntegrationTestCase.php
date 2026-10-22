<?php
namespace Onspli\Eladmin\Tests\Integration;

use PHPUnit\Framework\TestCase;

/**
* Serves tests/integration/fixture with PHP built-in server. Each test class gets its own server
* and a fresh working directory (sqlite database, sessions, blade cache).
*/
abstract class IntegrationTestCase extends TestCase {

  const ADMIN_LOGIN = 'eladmin';
  const ADMIN_PASSWORD = 'nimdale';

  protected static string $baseUrl;
  protected static string $workDir;
  private static $server = null;

  public static function setUpBeforeClass() : void {
    self::$workDir = sys_get_temp_dir() . '/eladmin-tests-' . bin2hex(random_bytes(6));
    mkdir(self::$workDir . '/sessions', 0777, true);

    $port = self::freePort();
    self::$baseUrl = 'http://127.0.0.1:' . $port;
    $command = [
      PHP_BINARY,
      '-d', 'session.save_path=' . self::$workDir . '/sessions',
      '-d', 'display_errors=0',
      '-d', 'log_errors=1',
      '-d', 'error_log=' . self::$workDir . '/php.log',
      '-S', '127.0.0.1:' . $port,
      '-t', __DIR__ . '/fixture',
    ];
    $env = array_merge(getenv(), ['ELADMIN_TEST_DIR' => self::$workDir]);
    $log = self::$workDir . '/server.log';
    self::$server = proc_open($command, [0 => ['pipe', 'r'], 1 => ['file', $log, 'a'], 2 => ['file', $log, 'a']], $pipes, null, $env);
    if (!is_resource(self::$server))
      throw new \RuntimeException('Cannot start PHP built-in server.');
    self::waitForServer($port);
  }

  public static function tearDownAfterClass() : void {
    if (is_resource(self::$server)) {
      proc_terminate(self::$server);
      proc_close(self::$server);
    }
    self::$server = null;
    self::removeDir(self::$workDir);
  }

  /**
  * Show PHP errors of the fixture app when a test fails.
  */
  protected function onNotSuccessfulTest(\Throwable $t) : never {
    $log = @file_get_contents(self::$workDir . '/php.log');
    if ($log)
      fwrite(STDERR, "\nFixture PHP log:\n" . $log . "\n");
    parent::onNotSuccessfulTest($t);
  }

  /**
  * New client without any session, like a fresh browser.
  */
  protected function client() : HttpClient {
    return new HttpClient(self::$baseUrl);
  }

  /**
  * Log in and return the client.
  */
  protected function loggedInClient(string $login = self::ADMIN_LOGIN, string $password = self::ADMIN_PASSWORD) : HttpClient {
    $client = $this->client();
    $response = $client->post(['elalogin' => 1], ['login' => $login, 'password' => $password]);
    $this->assertSame(302, $response->status, 'Login failed: ' . $response->body);
    return $client;
  }

  /**
  * CSRF token from a page rendered for the client.
  */
  protected function csrfToken(HttpClient $client) : string {
    $response = $client->get(['elamodule' => 'items']);
    $this->assertSame(200, $response->status);
    $this->assertMatchesRegularExpression("/_csrftoken = '([^']*)'/", $response->body);
    preg_match("/_csrftoken = '([^']*)'/", $response->body, $m);
    return $m[1];
  }

  /**
  * Run CRUD read action the way crud javascript does.
  */
  protected function crudRead(HttpClient $client, string $token, array $request = [], string $module = 'items') : HttpResponse {
    $request = array_merge([
      'sortBy' => '',
      'direction' => 'asc',
      'resultsPerPage' => 10,
      'page' => 1,
      'search' => '',
      'trash' => 0,
      'onlyIds' => 0,
    ], $request);
    return $client->ajax(['elamodule' => $module, 'elaaction' => 'read', 'elatoken' => $token], $request);
  }

  /**
  * Fixture sqlite database.
  */
  protected function db() : \PDO {
    $pdo = new \PDO('sqlite:' . self::$workDir . '/db.sqlite');
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    return $pdo;
  }

  private static function freePort() : int {
    $socket = stream_socket_server('tcp://127.0.0.1:0', $errno, $errstr);
    if (!$socket)
      throw new \RuntimeException('Cannot find free port: ' . $errstr);
    $name = stream_socket_get_name($socket, false);
    fclose($socket);
    return (int)substr(strrchr($name, ':'), 1);
  }

  private static function waitForServer(int $port) : void {
    for ($i = 0; $i < 100; $i++) {
      $connection = @fsockopen('127.0.0.1', $port, $errno, $errstr, 0.1);
      if ($connection) {
        fclose($connection);
        return;
      }
      usleep(50000);
    }
    throw new \RuntimeException('PHP built-in server did not start: ' . @file_get_contents(self::$workDir . '/server.log'));
  }

  private static function removeDir(string $dir) : void {
    if (!is_dir($dir))
      return;
    $items = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($items as $item)
      $item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
    rmdir($dir);
  }

}
