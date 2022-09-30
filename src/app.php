<?php
require_once __DIR__."/model/sheet.php";
require "route/sheet.php";
require "route/api.php";
require "lib.php";

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

function create_app($logger = null) {
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
      $logger->error($exception->getMessage());
      $response = $app->getResponseFactory()->createResponse();
      $response->getBody()->write(template('500.html'));
      return $response->withStatus(500);
  };
  
  $errorMiddleware = $app->addErrorMiddleware(true, true, true);
  $errorMiddleware->setDefaultErrorHandler($customErrorHandler);

  $so_sheety = new Sheet\SoSheety();

  $app = addAPIRoutes($app, $so_sheety);
  $app = addSheetRoutes($app, $so_sheety);

  return $app;
}
