<?php
use Nekofar\Slim\Test\Traits\AppTestTrait;
use PHPUnit\Framework\TestCase as BaseTestCase;

define('SHEET_MOCK', [
  "name" => "Merry",
  "race" => "Hobbit",
  "class" => "Rogue",
  "level" => "3",
  "int" => "16",
  "int_mod" => "+3",
  "int_saving_throw" => "+4",
  "wis" => "18",
  "wis_mod" => "+4",
  "wis_saving_throw" => "+5",
  "char" => "12",
  "char_mod" => "+2",
  "char_saving_throw" => "+5",
  "str" => "13",
  "str_mod" => "+1",
  "str_saving_throw" => "-2",
  "dex" => "17",
  "dex_mod" => "+3",
  "dex_saving_throw" => "+2",
  "con" => "10",
  "con_mod" => "-1",
  "con_saving_throw" => "-1",
  "hp_max" => "49",
  "hp_cur" => "25",
  "hp_tmp" => "0",
  "hit_die" => "1d8",
  "armor_class" => "16",
  "initiative" => "+3",
  "speed" => "30"
]);

class APITest extends BaseTestCase {
  use AppTestTrait;

  protected function setUp(): void {
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
    $request = $this->createJsonRequest('POST', '/api/sheet', SHEET_MOCK);

    $response = $this->app->handle($request);

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function test_incorrect_update_with_correct_id() {
    $request = $this->createJsonRequest('POST', '/api/sheet', SHEET_MOCK);

    $response = $this->app->handle($request);
    $data = json_decode((string)$response->getBody());

    $request = $this->createRequest('PUT', '/api/sheet/' . $data->id);
    $response = $this->app->handle($request);

    $this->assertEquals(400, $response->getStatusCode());
  }

  public function test_update_sheet() {
    $request = $this->createJsonRequest('POST', '/api/sheet', SHEET_MOCK);

    $response = $this->app->handle($request);

    $data = json_decode((string)$response->getBody());

    $request = $this->createJsonRequest('PUT', '/api/sheet/' . $data->id, SHEET_MOCK);
    $response = $this->app->handle($request);

    $this->assertEquals(200, $response->getStatusCode());
  }
}
