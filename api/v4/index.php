<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/slim/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/slim/dependencies.php';

// Register middleware
require __DIR__ . '/slim/middleware.php';

// Register routes
require __DIR__ . '/slim/routes/routes.php';

// Database connections
require  __DIR__ . '/slim/database.php';

// Run app
$app->run();