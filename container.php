<?php

global $container;

$container = new \Slim\Container([
    'displayErrorDetails' => true,
//    'routerCacheFile' => ROUTER_CACHE_FILE
]);

/**
 * @param $serviceName
 * @return object
 */
function getProvider($serviceName){
    global $container;
    $serviceName = lcfirst($serviceName);

    return $container[$serviceName];
}

$container['errorHandler'] = function ($container) {
    return \Twbot\Factory\LoggerFactory::getDefaultErrorHandler();
};