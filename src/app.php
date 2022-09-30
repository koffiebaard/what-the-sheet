<?php
require "route/sheet.php";
require "route/api.php";
require "lib.php";

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

function create_app() {
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
    bool $logErrorDetails,
    ?LoggerInterface $logger = null
  ) use ($app) {
      error_log($exception->getMessage(), 0);
      $response = $app->getResponseFactory()->createResponse();
      $response->getBody()->write(template('500.html'));
      return $response->withStatus(500);
  };

  $errorMiddleware = $app->addErrorMiddleware(true, true, true);
  $errorMiddleware->setDefaultErrorHandler($customErrorHandler);

  $app = addAPIRoutes($app);
  $app = addSheetRoutes($app);

  return $app;
}
