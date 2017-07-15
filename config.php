<?php
$config = [
    'database' => [
        'host' => 'localhost',
        'db_name' => 'test_app',
        'user' => 'root',
        'password' => '00',
    ],
    'path' => [
        'abs_path' => __DIR__,
        'controllers_path' => __DIR__ . '/lib/controllers',
        'models_path' => __DIR__ . '/lib/models',
        'views_path' => __DIR__ . '/lib/views',
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
    ]
];
