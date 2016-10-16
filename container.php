<?php

global $container;

$container = new \Slim\Container([
    'settings' => [
//        'routerCacheFile' => ROUTER_CACHE_FILE,
//        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails' => true,
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'scotchbox',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]
    ],
]);

/**
 * @param $serviceName
 * @return object
 */
function getProvider($serviceName)
{
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

$container['db'] = function ($container) {
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};

/**
 * Services
 */
$container['proxyService'] = function ($container) {
    $logger = \Twbot\Factory\LoggerFactory::getLogger(\Twbot\Enumerator\LoggerEnumerator::PROXY_LOGGER);

    return new \Twbot\Service\ProxyService($logger);
};

$container['twitterFollowRepository'] = function ($container) {
    return new \Twbot\Repository\TwitterFollowRepository();
};

/**
 * Events
 */
$container['dispatcher']->addListener(\Twbot\Enumerator\EventEnumerator::ACCOUNT_FOUND_EVENT, function (\Twbot\Event\AccountFound $event) {
    $account = $event->getAccount();
    $proxyId = $account->getProxyId();

    if (!empty($proxyId)) {
        $account->setProxy(\Twbot\Repository\ProxyRepository::getProxyById($proxyId));
    }

    $event->setAccount($account);
});
$container['dispatcher']->addListener(\Twbot\Enumerator\EventEnumerator::ACCOUNT_PROXY_SET_EVENT, function (\Twbot\Event\AccountProxySet $event) {
    $proxy = $event->getAccount()->getProxy();

    if ($proxy) {
        /**
         * @var \Twbot\Service\ProxyService $proxyService
         */
        $proxyService = getProvider('proxyService');
        $proxyService->setProxy($proxy);

        if (!$proxyService->ping()) {
            $event->stopPropagation();
        }
    }
});