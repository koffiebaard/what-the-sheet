<?php
require_once(__DIR__.'/../src/logger.php');

use Nekofar\Slim\Test\Traits\AppTestTrait;
use PHPUnit\Framework\TestCase as BaseTestCase;

class SheetTest extends BaseTestCase 
{
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

  public function test_incorrect_id_not_hex() {
    $request = $this->createRequest('GET', '/12345afZZZZ');
    $response = $this->app->handle($request);

    $this->assertEquals(404, $response->getStatusCode());
  }

  public function test_sheet_form() {
    // Create sheet
    $request = $this->createJsonRequest('POST', '/api/sheet', VALID_SHEET_MOCK);
    $response = $this->app->handle($request);
    $creation_response_body = json_decode((string)$response->getBody());

    // Verify sheet was created
    $this->assertObjectHasAttribute('id', $creation_response_body);

    // Retrieve form and see a 200
    $request = $this->createRequest('GET', '/'.$creation_response_body->id);
    $response = $this->app->handle($request);

    $this->assertEquals(200, $response->getStatusCode());

    // Clean up after, we're not animals
    $this->clean_up($creation_response_body->id);
  }

  public function test_sheet_share() {
    // Create sheet
    $api_request = $this->createJsonRequest('POST', '/api/sheet', VALID_SHEET_MOCK);
    $api_response = $this->app->handle($api_request);
    $creation_response_body = json_decode((string)$api_response->getBody());

    // Verify sheet was created
    $this->assertObjectHasAttribute('id', $creation_response_body);
    $this->assertObjectHasAttribute('share_token', $creation_response_body);

    // Retrieve share page and see a 200
    $request = $this->createRequest('GET', '/share/'.$creation_response_body->share_token);
    $response = $this->app->handle($request);

    $this->assertEquals(200, $response->getStatusCode());

    // Clean up after, we're not animals
    $this->clean_up($creation_response_body->id);
  }
}
