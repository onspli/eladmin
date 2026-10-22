<?php
namespace Onspli\Eladmin\Tests\Integration;

/**
* HTTP response received by HttpClient.
*/
final class HttpResponse {

  /**
  * @param $headers array of lowercase header name => list of values
  */
  public function __construct(
    public readonly int $status,
    public readonly array $headers,
    public readonly string $body
  ) {}

  /**
  * First value of the header, null if not present.
  */
  public function header(string $name) : ?string {
    return $this->headers[strtolower($name)][0] ?? null;
  }

  /**
  * Decoded JSON body.
  */
  public function json() {
    return json_decode($this->body, true, 512, JSON_THROW_ON_ERROR);
  }

}
