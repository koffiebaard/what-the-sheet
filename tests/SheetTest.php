<?php
require_once(__DIR__.'/../src/logger.php');

use Nekofar\Slim\Test\Traits\AppTestTrait;
use PHPUnit\Framework\TestCase as BaseTestCase;

class SheetTest extends BaseTestCase 
{
  use AppTestTrait;

  protected function setUp(): void
  {
    $logger = create_logger();
    $app = create_app($logger);
    $this->setUpApp($app);
  }

  public function test_empty_sheet() {
    $request = $this->createRequest('GET', '/');
    $response = $this->app->handle($request);

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function test_incorrect_id() {
    $request = $this->createRequest('GET', '/12345af');
    $response = $this->app->handle($request);

    $this->assertEquals(404, $response->getStatusCode());
  }
}
