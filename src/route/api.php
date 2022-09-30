<?php
require_once __DIR__."/../model/sheet.php";

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

function addAPIRoutes($app) {
  // Create sheet
  $app->post('/api/sheet', function (Request $request, Response $response, $args) {
    $so_sheety = new Sheet\SoSheety();
    $req_data = json_decode($request->getBody(), true) ?? [];

    // 400 Bad Request
    $errors = $so_sheety->validate($req_data);
    if (count($errors) !== 0) {
      return error_response($response, "Errors occurred while validating the request.", 400, $errors);
    }

    // Create sheet
    $sheet = $so_sheety->create_sheet($req_data['name'], $req_data['race'], $req_data['class']);
    $response->getBody()->write(json_encode($sheet));

    return $response->withHeader('Content-type', 'application/json');
  });

  // Update sheet
  $app->put('/api/sheet/{id:[a-f0-9]+}', function (Request $request, Response $response, $args) {
    $so_sheety = new Sheet\SoSheety();
    $req_data = json_decode($request->getBody(), true) ?? [];

    // 404 not found
    if ($so_sheety->get_by_id($args['id']) === false) {
      return error_response($response, "Sheet not found", 404);
    }

    // 400 Bad Request
    $errors = $so_sheety->validate($req_data);
    if (count($errors) !== 0) {
      return error_response($response, "Errors occurred while validating the request.", 400, $errors);
    }

    // Update sheet
    $sheet = $so_sheety->update_sheet($args['id'], $req_data['name'], $req_data['race'], $req_data['class']);
    $response->getBody()->write(json_encode($sheet));

    return $response->withHeader('Content-type', 'application/json');
  });

  return $app;
}
