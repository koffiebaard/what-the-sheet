<?php
require_once(__DIR__.'/database.php');
require_once(__DIR__.'/model/sheet.php');
require_once(__DIR__.'/route/sheet.php');
require_once(__DIR__.'/route/api.php');
require_once(__DIR__.'/lib.php');

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

function create_app(Monolog\Logger $logger) {
  // Create Container using PHP-DI
  $container = new Container();
  AppFactory::setContainer($container);

  $app = AppFactory::create();
  $app->addRoutingMiddleware();

  $customErrorHandler = function (
    Request $request,
    Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails
  ) use (
    $app,
    $logger
  ) {
    $logger->error($exception);

    $response = $app->getResponseFactory()->createResponse();
    $response_code = $exception->getCode() == 404 ? 404 : 500;

    // Show API response if it's an API request
    if (str_starts_with($request->getUri()->getPath(), '/api/')) {
      return error_response($response, "Something went wrong. I've seen some sheet.", $response_code);
    }

    // Show HTML response on an HTML request
    $response->getBody()->write(template("$response_code.html"));
    return $response->withStatus($response_code);
  };
  
  $errorMiddleware = $app->addErrorMiddleware(true, true, true);
  $errorMiddleware->setDefaultErrorHandler($customErrorHandler);

  $db_connection = connect_database();

  $app = addAPIRoutes($app, $db_connection);
  $app = addSheetRoutes($app, $db_connection);

  return $app;
}
