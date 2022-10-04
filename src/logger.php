<?php
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

function create_logger() {
  $logger = new Logger('what-the-sheet');
  $logger->pushHandler(new StreamHandler(__DIR__.'/../logs/log.log', Level::Warning));

  // Local development also wants errors in stdout
  if (getenv('DEVELOPMENT')) {
    $logger->pushHandler(new \Monolog\Handler\ErrorLogHandler());
  }

  return $logger;
}

$logger = create_logger();
