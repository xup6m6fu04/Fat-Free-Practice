<?php


return [

    'default' => $_ENV['DB_CONNECTION'],

    'connections' => [

        'mysql' => [
            'driver' => 'mysql',
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'database' => $_ENV['DB_DATABASE'],
            'username' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'unix_socket' => $_ENV['DB_SOCKET'],
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

    ],

];
