<?php
$config = [
    'logger' => $loggerConfig = [
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
