<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App as App;
use Sheet\SoSheety as SoSheety;

function addSheetRoutes(App $app, PDO $db_connection) {
  $so_sheety = new SoSheety($db_connection);

  // Empty sheet
  $app->get('/', function (Request $request, Response $response, array $args) use ($so_sheety) {
    $response->getBody()->write(template(
      'show_the_sheet.php',
      [
        'web_address' => getenv('WTS_WEB_ADDRESS')
      ]
    ));
    return $response;
  });

  // Sheet by ID
  $app->get('/{id:[a-f0-9]+}', function (Request $request, Response $response, array $args) use ($so_sheety) {
    $sheet = $so_sheety->get_by_id($args['id']);

    // 404 not found
    if ($sheet === false) {
      $response->getBody()->write(template('404.html'));
      return $response->withStatus(404);
    }

    $response->getBody()->write(template(
      'show_the_sheet.php',
      [
        'sheet' => $sheet,
        'web_address' => getenv('WTS_WEB_ADDRESS')
      ]
    ));
    return $response;
  });

  // Sheet by share token
  $app->get('/share/{token:[a-f0-9]+}', function (Request $request, Response $response, array $args) use ($so_sheety) {
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
