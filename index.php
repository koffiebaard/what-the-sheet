<?php
error_reporting(E_ALL);
require 'vendor/autoload.php';
require "sheet.php";

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

// Create sheet
$app->post('/api/sheet', function (Request $request, Response $response, $args) {
  header('Content-Type: application/json; charset=utf-8');

  $required_fields = ['name', 'race', 'class'];
  $request_data = json_decode($request->getBody(), true);

  // 400 Bad Request
  if (count(array_intersect_key(array_flip($required_fields), $request_data)) !== count($required_fields)) {
    $response->getBody()->write('{"error": "What the sheet is this?"}');
    return $response->withStatus(400);
  }

  // Create sheet
  $so_sheety = new SoSheety();
  $id = $so_sheety->create_sheet($request_data['name'], $request_data['race'], $request_data['class']);
  $response->getBody()->write('{"id": "' . $id . '"}');

  return $response;
});

// Update sheet
$app->put('/api/sheet/{id:[a-f0-9]+}', function (Request $request, Response $response, $args) {
  header('Content-Type: application/json; charset=utf-8');

  $so_sheety = new SoSheety();
  $sheet = $so_sheety->get_by_id($args['id']);
  
  // 404 not found
  if ($sheet === false) {
    $response->getBody()->write('No sheet found.');
    return $response->withStatus(404);
  }

  $required_fields = ['name', 'race', 'class'];
  $request_data = json_decode($request->getBody(), true);

  // 400 bad request
  if (count(array_intersect_key(array_flip($required_fields), $request_data)) !== count($required_fields)) {
    $response->getBody()->write('{"error": "What the sheet is this? Not all fields are present"}');
    return $response->withStatus(400);
  }

  // Update sheet
  $so_sheety->update_sheet($args['id'], $request_data['name'], $request_data['race'], $request_data['class']);
  $response->getBody()->write('{"id": "' . $args['id'] . '"}');

  return $response;
});

// Empty sheet
$app->get('/', function (Request $request, Response $response, $args) {
  ob_start();
  require 'show_the_sheet.php';
  $content = ob_get_clean();
  $response->getBody()->write($content);
  
  return $response;
});

// Sheet by ID
$app->get('/{id:[a-f0-9]+}', function (Request $request, Response $response, $args) {
  $so_sheety = new SoSheety();
  $sheet = $so_sheety->get_by_id($args['id']);

  // 404 not found
  if ($sheet === false) {
    $response->getBody()->write('No sheet found.');
    return $response->withStatus(404);
  }

  ob_start();
  require 'show_the_sheet.php';
  $content = ob_get_clean();
  $response->getBody()->write($content);

  return $response;
});

$app->run();
