<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

function addSheetRoutes($app, $so_sheety) {
  // Empty sheet
  $app->get('/', function (Request $request, Response $response, $args) use ($so_sheety) {
    $response->getBody()->write(template('show_the_sheet.php'));
    return $response;
  });

  // Sheet by ID
  $app->get('/{id:[a-f0-9]+}', function (Request $request, Response $response, $args) use ($so_sheety) {
    $sheet = $so_sheety->get_by_id($args['id']);

    // 404 not found
    if ($sheet === false) {
      $response->getBody()->write(template('404.html'));
      return $response->withStatus(404);
    }

    $response->getBody()->write(template(
      'show_the_sheet.php',
      [
      'sheet' => $sheet
      ]
    ));
    return $response;
  });

  // Sheet by share token
  $app->get('/share/{token:[a-f0-9]+}', function (Request $request, Response $response, $args) use ($so_sheety) {
    $sheet = $so_sheety->get_by_share_token($args['token']);

    // 404 not found
    if ($sheet === false) {
      $response->getBody()->write(template('404.html'));
      return $response->withStatus(404);
    }

    $response->getBody()->write(template(
      'share_the_sheet.php',
      [
      'sheet' => $sheet
      ]
    ));
    return $response;
  });

  return $app;
}
