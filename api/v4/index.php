<?php
require '../../vendor/autoload.php';

/* App Config */
$config['displayErrorDetails'] = true;

// Initialize Slim
$app = new \Slim\App(["settings" => $config]);

/* Set up Logging to /logs/app.log with Monolog */
$container = $app->getContainer();
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('openFFS REST');
    $file_handler = new \Monolog\Handler\StreamHandler("logs/app.log");
    $logger->pushHandler($file_handler);
    return $logger;
};

//include database connection
require_once 'database/connection.php';

//include the routes
require_once 'routes/routes.php';

/* Kickstart App */
$app->run();
