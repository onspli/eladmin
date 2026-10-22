<?php
namespace Onspli\Eladmin\Tests\Integration;

final class AssetTest extends IntegrationTestCase {

  public function testCoreAssetsArePublic() : void {
    // the login page needs them
    $response = $this->client()->get(['elamodule' => '', 'elaasset' => 'layout.css']);
    $this->assertSame(200, $response->status);
    $this->assertStringStartsWith('text/css', $response->header('Content-Type'));
  }

  public function testModuleAssetsRequireLogin() : void {
    $response = $this->client()->ajax(['elamodule' => 'items', 'elaasset' => 'script.js']);
    $this->assertSame(401, $response->status);
  }

  public function testModuleAssetsRedirectAnonymousBrowserToLogin() : void {
    $response = $this->client()->get(['elamodule' => 'items', 'elaasset' => 'script.js']);
    $this->assertSame(302, $response->status);
  }

  public function testModuleAssetsAreServedToLoggedInUser() : void {
    $response = $this->loggedInClient()->get(['elamodule' => 'items', 'elaasset' => 'script.js']);
    $this->assertSame(200, $response->status);
    $this->assertStringStartsWith('text/javascript', $response->header('Content-Type'));
    // session must not add its no-cache headers to assets
    $this->assertStringContainsString('max-age=', $response->header('Cache-Control'));
    $this->assertNull($response->header('Pragma'));
  }

  public function testPathTraversalIsRejected() : void {
    $response = $this->client()->ajax(['elamodule' => '', 'elaasset' => '../modules/core/login.blade.php']);
    $this->assertSame(401, $response->status);
  }

  public function testOnlyCssAndJsAreServed() : void {
    $response = $this->loggedInClient()->ajax(['elamodule' => '', 'elaasset' => 'toastr-2.1.3/../layout.blade.php']);
    $this->assertSame(401, $response->status);
  }

}
