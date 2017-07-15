<?php
$config = [
    'database' => [
        'host' => '',
        'db_name' => '',
        'user' => '',
        'password' => '',
    ],
    'path' => [
        'abs_path' => __DIR__,
        'controllers_path' => __DIR__ . '/controllers',
        'models_path' => __DIR__ . '/models',
        'views_path' => __DIR__ . '/views',
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
