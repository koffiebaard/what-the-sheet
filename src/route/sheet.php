<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

function addSheetRoutes($app) {
  // Empty sheet
  $app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write(template('show_the_sheet.php'));
    return $response;
  });

  // Sheet by ID
  $app->get('/{id:[a-f0-9]+}', function (Request $request, Response $response, $args) {
    $so_sheety = new SoSheety();
    $sheet = $so_sheety->get_by_id($args['id']);

    // 404 not found
    if ($sheet === false) {
      $response->getBody()->write(template('404.html'));
      return $response->withStatus(404);
    }

    $response->getBody()->write(template(
      'show_the_sheet.php', [
      'sheet' => $sheet
    ]));
    return $response;
  });

  return $app;
}
