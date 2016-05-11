<?php
// Application middleware

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