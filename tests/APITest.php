<?php
use Nekofar\Slim\Test\Traits\AppTestTrait;
use PHPUnit\Framework\TestCase as BaseTestCase;

class APITest extends BaseTestCase 
{
  use AppTestTrait;

  protected function setUp(): void
  {
    $app = create_app();
    $this->setUpApp($app);
  }

  public function test_create_without_parameters() {
    $request = $this->createRequest('POST', '/api/sheet');
    $response = $this->app->handle($request);

    $this->assertEquals(400, $response->getStatusCode());
  }

  public function test_update_withoout_correct_id() {
    $request = $this->createRequest('PUT', '/api/sheet/abcd1234');
    $response = $this->app->handle($request);

    $this->assertEquals(404, $response->getStatusCode());
  }

  public function test_create_sheet() {
    $request = $this->createJsonRequest('POST', '/api/sheet', [
      "name"  => "Pippin",
      "race"  => "Hobbit",
      "class" => "Bard"
    ]);

    $response = $this->app->handle($request);

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function test_incorrect_update_with_correct_id() {
    $request = $this->createJsonRequest('POST', '/api/sheet', [
      "name"  => "Pippin",
      "race"  => "Hobbit",
      "class" => "Bard"
    ]);

    $response = $this->app->handle($request);
    $data = json_decode((string)$response->getBody());

    $request = $this->createRequest('PUT', '/api/sheet/' . $data->id);
    $response = $this->app->handle($request);

    $this->assertEquals(400, $response->getStatusCode());
  }

  public function test_update_sheet() {
    $request = $this->createJsonRequest('POST', '/api/sheet', [
      "name"  => "Pippin",
      "race"  => "Hobbit",
      "class" => "Bard"
    ]);

    $response = $this->app->handle($request);

    $data = json_decode((string)$response->getBody());

    $request = $this->createJsonRequest('PUT', '/api/sheet/' . $data->id, [
      "name"  => "Pippin",
      "race"  => "Halfling",
      "class" => "Rogue"
    ]);
    $response = $this->app->handle($request);

    $this->assertEquals(200, $response->getStatusCode());
  }
}
