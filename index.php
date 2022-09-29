<?php
error_reporting(E_ALL);
require 'vendor/autoload.php';
require "app.php";

$app = create_app();
$app->run();
