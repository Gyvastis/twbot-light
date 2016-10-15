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

$container['proxyService'] = function($container) {
    $logger = \Twbot\Factory\LoggerFactory::getLogger(\Twbot\Enumerator\LoggerEnumerator::PROXY_LOGGER);

    return new \Twbot\Service\ProxyService($logger);
};

$container['dispatcher'] = function ($container) {
    return new Symfony\Component\EventDispatcher\EventDispatcher();
};

/**
 * Events
 */
$container['dispatcher']->addListener(\Twbot\Enumerator\EventEnumerator::ACCOUNT_FOUND_EVENT, function (\Twbot\Event\AccountFound $event) {
    $account = $event->getAccount();
    $proxyId = $account->getProxyId();

    if(!empty($proxyId)) {
        $account->setProxy(\Twbot\Repository\ProxyRepository::getProxyById($proxyId));
    }

    $event->setAccount($account);
});
$container['dispatcher']->addListener(\Twbot\Enumerator\EventEnumerator::ACCOUNT_PROXY_SET_EVENT, function (\Twbot\Event\AccountProxySet $event) {
    $proxy = $event->getAccount()->getProxy();

    if($proxy->getIpAddress() != '' && $proxy->getPort() != ''){
        /**
         * @var \Twbot\Service\ProxyService $proxyService
         */
        $proxyService = getProvider('proxyService');

        $proxyService->setProxy($proxy);

        if(!$proxyService->ping()){
            $event->stopPropagation();
        }
    }
});