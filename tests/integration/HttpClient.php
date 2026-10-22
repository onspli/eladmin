<?php
namespace Onspli\Eladmin\Tests\Integration;

/**
* Minimal HTTP client with a cookie jar, acts like a single browser.
* Uses PHP streams, so it doesn't require the curl extension. Doesn't follow redirects.
*/
final class HttpClient {

  /**
  * Cookies in the form name => value.
  */
  public array $cookies = [];

  public function __construct(private string $baseUrl) {}

  public function get(array $query = [], array $headers = []) : HttpResponse {
    return $this->request('GET', $query, null, $headers);
  }

  public function post(array $query = [], array $post = [], array $headers = []) : HttpResponse {
    return $this->request('POST', $query, $post, $headers);
  }

  /**
  * Request issued by eladmin javascript (jQuery ajax).
  */
  public function ajax(array $query = [], array $post = [], array $headers = []) : HttpResponse {
    return $this->post($query, $post, array_merge(['X-Requested-With' => 'XMLHttpRequest'], $headers));
  }

  public function request(string $method, array $query, ?array $post, array $headers) : HttpResponse {
    $url = $this->baseUrl . '/' . ($query ? '?' . http_build_query($query) : '');
    if ($this->cookies) {
      $pairs = [];
      foreach ($this->cookies as $name => $value)
        $pairs[] = $name . '=' . $value;
      $headers['Cookie'] = implode('; ', $pairs);
    }
    $content = '';
    if ($post !== null) {
      $headers['Content-Type'] = 'application/x-www-form-urlencoded';
      $content = http_build_query($post);
    }
    $headerLines = [];
    foreach ($headers as $name => $value)
      $headerLines[] = $name . ': ' . $value;

    $context = stream_context_create(['http' => [
      'method' => $method,
      'header' => implode("\r\n", $headerLines),
      'content' => $content,
      'follow_location' => 0,
      'ignore_errors' => true,
      'timeout' => 10,
    ]]);
    $body = file_get_contents($url, false, $context);
    if ($body === false)
      throw new \RuntimeException('Request to ' . $url . ' failed.');
    // http_get_last_response_headers() replaces $http_response_header since PHP 8.4
    $rawHeaders = function_exists('http_get_last_response_headers') ? http_get_last_response_headers() : $http_response_header;
    return $this->parseResponse($rawHeaders ?? [], $body);
  }

  private function parseResponse(array $rawHeaders, string $body) : HttpResponse {
    $status = 0;
    $headers = [];
    foreach ($rawHeaders as $line) {
      if (preg_match('#^HTTP/\S+\s+(\d{3})#', $line, $m)) {
        $status = (int)$m[1];
        continue;
      }
      [$name, $value] = array_map('trim', explode(':', $line, 2)) + [1 => ''];
      $headers[strtolower($name)][] = $value;
    }
    foreach ($headers['set-cookie'] ?? [] as $cookie) {
      [$pair] = explode(';', $cookie, 2);
      [$name, $value] = explode('=', $pair, 2) + [1 => ''];
      $this->cookies[trim($name)] = trim($value);
    }
    return new HttpResponse($status, $headers, $body);
  }

}
