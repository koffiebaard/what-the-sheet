<?php
error_reporting(E_ALL);
require_once '../vendor/autoload.php';
require "app.php";
require "logger.php";

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

$app = create_app($logger);
$app->run();
