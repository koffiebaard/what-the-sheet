<?php
require_once __DIR__.'/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->safeLoad();

return
[
    'paths' => [
        'migrations' => __DIR__.'/db/migrations',
        'seeds' => __DIR__.'/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'whatthesheet',
        'whatthesheet' => [
            'adapter' => getenv('WTS_DB_IN_MEMORY') ? 'sqlite' : 'mysql',
            'host' => getenv('WTS_DB_HOSTNAME'),
            'name' => getenv('WTS_DB_NAME'),
            'user' => getenv('WTS_DB_USERNAME'),
            'pass' => getenv('WTS_DB_PASSWORD'),
            'port' => '3306',
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
