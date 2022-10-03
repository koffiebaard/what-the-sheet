<?php
require_once 'logger.php';

use Phinx\Config\Config;
use Phinx\Migration\Manager;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

function connect_database() {
  $logger = create_logger();

  try {
    // Create a connection purely in memory for tests
    if (getenv('WTS_DB_IN_MEMORY') && getenv('WTS_DB_IN_MEMORY') == 1) {
      return create_memory_database();
    }

    // Create a regular MySQL connection
    return new PDO(
      'mysql:host=' . getenv('WTS_DB_HOSTNAME') . ';dbname=' . getenv('WTS_DB_NAME'),
      getenv('WTS_DB_USERNAME'),
      getenv('WTS_DB_PASSWORD')
    );
  } catch (Exception $e) {
    $logger->error($e->getMessage());
    die("Something went wrong.");
  }
}

function create_memory_database() {
  // Memory db connection
  $db_connection = new PDO('sqlite::memory:', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  ]);

  // Add migration configuration for the memory database
  $configArray = require('phinx.php');
  $configArray['environments']['test'] = [
    'adapter'    => 'sqlite',
    'connection' => $db_connection
  ];
  $config = new Config($configArray);

  // Run migrations on this connection
  $manager = new Manager($config, new StringInput(' '), new NullOutput());
  $manager->migrate('test');

  return $db_connection;
}
