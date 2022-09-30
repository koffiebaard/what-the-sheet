<?php
error_reporting(E_ALL);
require_once '../vendor/autoload.php';
require "app.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$app = create_app();
$app->run();
