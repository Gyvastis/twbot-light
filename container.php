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

$container['dispatcher'] = function ($container) {
    return new Symfony\Component\EventDispatcher\EventDispatcher();
};

$container['dispatcher']->addListener(\Twbot\Enumerator\EventEnumerator::ACCOUNT_FOUND_EVENT, function (\Twbot\Event\AccountFound $event) {
    $account = $event->getAccount();

    $account->setProxy(\Twbot\Repository\ProxyRepository::getProxyById($account->getProxyId()));

    $event->setAccount($account);
});