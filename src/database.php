<?php
use Phinx\Config\Config;
use Phinx\Migration\Manager;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

function connect_database(): PDO {
  $db_options = [
    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
  ];

  // Create a connection purely in memory for tests
  if (getenv('WTS_DB_IN_MEMORY') && getenv('WTS_DB_IN_MEMORY') == 1) {
    return create_memory_database($db_options);
  }

  // Create a regular MySQL connection
  return new PDO(
    'mysql:host=' . getenv('WTS_DB_HOSTNAME') . ';dbname=' . getenv('WTS_DB_NAME'),
    getenv('WTS_DB_USERNAME'),
    getenv('WTS_DB_PASSWORD'),
    $db_options
  );
}

function create_memory_database(array $db_options): PDO {
  // Memory db connection
  $db_connection = new PDO('sqlite::memory:', null, null, $db_options);

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
