<?php
$config = [
    'database' => [
        'host' => '',
        'db_name' => '',
        'user' => '',
        'password' => '',
    ],
    'path' => [
        'absolute' => __DIR__,
        'controllers' => __DIR__ . '/lib/controllers',
        'models' => __DIR__ . '/lib/models',
        'views' => __DIR__ . '/lib/views',
        'views_cache' => __DIR__ . '/lib/views/cache',
    ],
    'logger' => [
        'default' => [
            [
                'type' => 'stream',
                // the level of log messages to include (optional)
                'level' => \Psr\Log\LogLevel::ERROR,
                // logger specific parameters
                'path' => __DIR__ . '/logs/app.log'
            ]
        ]
    ],
];
