<?php
$config = [
    'database' => [
        'host' => 'localhost',
        'db_name' => 'test_app',
        'user' => 'root',
        'password' => '00',
    ],
    'application' => [
        'absolute_path' => __DIR__,
        'controllers' => __DIR__ . '/lib/controllers',
        'models' => __DIR__ . '/lib/models',
        'views' => __DIR__ . '/lib/views',
        'views_cache' => __DIR__ . '/lib/views/cache',
    ],
    'pictures' => [
        'max_width' => 320,
        'max_height' => 240,
        'path' => __DIR__ . '/pictures',
    ],
    'logger' => [
        'default' => [
            [
                'type' => 'stream',
                // the level of log messages to include (optional)
                'level' => \Psr\Log\LogLevel::INFO,
                // logger specific parameters
                'path' => __DIR__ . '/logs/app.log'
            ]
        ]
    ]
];
