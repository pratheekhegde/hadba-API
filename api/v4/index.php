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
    $file_handler = new \Monolog\Handler\StreamHandler('./logs/'.date('Y-m-d').'.log');
    $logger->pushHandler($file_handler);
    return $logger;
};


/*
* This middleware checks the 'X-Forwarded-For', 'X-Forwarded', 'X-Cluster-Client-Ip', 'Client-Ip' headers for the first IP address it can find.
* If none of the headers exist, or do not have a valid IP address, then the $_SERVER['REMOTE_ADDR'] is used.
*
* Note that the proxy headers are only checked if the first parameter to the constructor is set to true.
* If set to false, then only $_SERVER['REMOTE_ADDR'] is used
*/

// Note: Never trust the IP address for security processes!
$checkProxyHeaders = false;
$trustedProxies = ['10.0.0.1', '10.0.0.2'];

$app->add(new RKA\Middleware\IpAddress($checkProxyHeaders, $trustedProxies));

//include database connection
require_once 'database/connection.php';

//include the routes
require_once 'routes/routes.php';

/* Kickstart App */
$app->run();
