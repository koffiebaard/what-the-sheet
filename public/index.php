<?php
date_default_timezone_set('UTC');

ini_set('display_startup_errors', 0);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__.'/../logs/php.log');
error_reporting(E_ALL);

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../src/env.php';
require_once __DIR__.'/../src/lib.php';
require_once __DIR__.'/../src/app.php';
require_once __DIR__.'/../src/logger.php';

if (getenv('DEVELOPMENT')) {
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
}

$app = create_app($logger);
$app->run();
