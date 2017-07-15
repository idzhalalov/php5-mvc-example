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
        'host' => '',
        'db_name' => '',
        'user' => '',
        'password' => '',
    ],
    'abs_path' => __DIR__,
];
