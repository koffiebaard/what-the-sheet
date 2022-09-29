<?php
require PROJECT_ROOT . '/app.php';

use Nekofar\Slim\Test\Traits\AppTestTrait;
use PHPUnit\Framework\TestCase as BaseTestCase;

class SheetTest extends BaseTestCase 
{
  use AppTestTrait;

  protected function setUp(): void
  {
    $app = create_app();
    $this->setUpApp($app);
  }

  public function testPOSTRequestWithoutParameters() {
    $request = $this->createRequest('POST', '/api/sheet');
    $response = $this->app->handle($request);

    $this->assertEquals(400, $response->getStatusCode());
  }

  public function testPUTRequestWithoutCorrectID() {
    $request = $this->createRequest('PUT', '/api/sheet/abcd1234');
    $response = $this->app->handle($request);

    $this->assertEquals(404, $response->getStatusCode());
  }

  public function testCreateSheet() {
    $request = $this->createJsonRequest('POST', '/api/sheet', [
      "name"  => "Pippin",
      "race"  => "Hobbit",
      "class" => "Bard"
    ]);

    $response = $this->app->handle($request);

    $this->assertEquals(200, $response->getStatusCode());
  }
}
