<?php
date_default_timezone_set('UTC');

// Disable errors and logging to stdout while running tests
error_reporting(-1);
ini_set('display_errors', 0);
ini_set('log_errors', 0);
putenv("DEVELOPMENT=0");

define('PROJECT_ROOT', realpath(__DIR__ . '/..'));

require_once(PROJECT_ROOT.'/vendor/autoload.php');
require_once(PROJECT_ROOT . '/src/app.php');
require_once(__DIR__.'/mocks.php');

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/..');
$dotenv->safeLoad();
