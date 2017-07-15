<?php
$config = [
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
    'database' => [
        'host' => 'localhost',
        'db_name' => 'test_app',
        'user' => 'root',
        'password' => '00',
    ],
    'abs_path' => __DIR__,
];
