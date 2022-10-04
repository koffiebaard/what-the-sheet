<?php
require_once(__DIR__.'/../src/logger.php');

use Nekofar\Slim\Test\Traits\AppTestTrait;
use PHPUnit\Framework\TestCase as BaseTestCase;

class APITest extends BaseTestCase {
  use AppTestTrait;

  protected function setUp(): void {
    $logger = create_logger();
    $app = create_app($logger);
    $this->setUpApp($app);
  }

  public function clean_up($id) {
    $request = $this->createJsonRequest('DELETE', '/api/sheet/' . $id);
    $this->app->handle($request);
  }

  public function test_create_without_parameters() {
    $request = $this->createRequest('POST', '/api/sheet');
    $response = $this->app->handle($request);

    $this->assertEquals(400, $response->getStatusCode());
    $response_body = json_decode((string)$response->getBody());
    $this->assertObjectHasAttribute('message', $response_body);
    $this->assertIsArray($response_body->errors);
  }

  public function test_update_incorrect_id() {
    $request = $this->createRequest('PUT', '/api/sheet/abcd1234');
    $response = $this->app->handle($request);
    $response_body = json_decode((string)$response->getBody());

    $this->assertEquals(404, $response->getStatusCode());
    $this->assertObjectHasAttribute('message', $response_body);
  }

  public function test_update_incorrect_id_not_hex() {
    $request = $this->createRequest('PUT', '/api/sheet/abcd1234ZZZ');
    $response = $this->app->handle($request);
    $response_body = json_decode((string)$response->getBody());

    $this->assertEquals(404, $response->getStatusCode());
    $this->assertObjectHasAttribute('message', $response_body);
  }

  public function test_create_sheet() {
    $request = $this->createJsonRequest('POST', '/api/sheet', VALID_SHEET_MOCK);

    $response = $this->app->handle($request);
    $response_body = json_decode((string)$response->getBody());

    $this->assertEquals(200, $response->getStatusCode());
    $this->assertObjectHasAttribute('id', $response_body);
    $this->assertObjectHasAttribute('name', $response_body);
    $this->assertObjectHasAttribute('class', $response_body);
    $this->assertObjectHasAttribute('race', $response_body);
    $this->assertObjectHasAttribute('share_token', $response_body);

    // Clean up after, we're not animals
    $this->clean_up($response_body->id);
  }

  public function test_incorrect_update_with_correct_id() {
    $request = $this->createJsonRequest('POST', '/api/sheet', VALID_SHEET_MOCK);

    $response = $this->app->handle($request);
    $creation_response_body = json_decode((string)$response->getBody());

    $request = $this->createRequest('PUT', '/api/sheet/' . $creation_response_body->id);
    $response = $this->app->handle($request);
    $response_body = json_decode((string)$response->getBody());

    $this->assertEquals(400, $response->getStatusCode());
    $this->assertObjectHasAttribute('message', $response_body);

    // Clean up after, we're not animals
    $this->clean_up($creation_response_body->id);
  }

  public function test_update_sheet() {
    $request = $this->createJsonRequest('POST', '/api/sheet', VALID_SHEET_MOCK);

    $response = $this->app->handle($request);

    $data = json_decode((string)$response->getBody());

    $request = $this->createJsonRequest('PUT', '/api/sheet/' . $data->id, VALID_SHEET_MOCK);
    $response = $this->app->handle($request);

    $this->assertEquals(200, $response->getStatusCode());

    // Clean up after, we're not animals
    $this->clean_up($data->id);
  }

  public function test_delete_sheet() {
    $request = $this->createJsonRequest('POST', '/api/sheet', VALID_SHEET_MOCK);
    $response = $this->app->handle($request);

    $data = json_decode((string)$response->getBody());

    $request = $this->createJsonRequest('DELETE', '/api/sheet/' . $data->id);
    $response = $this->app->handle($request);

    $this->assertEquals(200, $response->getStatusCode());
  }
}
