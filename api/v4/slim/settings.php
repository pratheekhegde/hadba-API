<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        // Renderer settings

        // Monolog settings
        'logger' => [
            'name' => 'hadba-REST',
            'path' => __DIR__ . '/../logs/'.date('Y-m-d').'.log',
        ],
    ],
];