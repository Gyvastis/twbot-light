<?php

require '../config.php';

global $container;
$app = new \Slim\App($container);

$app->get('/ping-proxy/{id}', function ($request, $response, $args) {
    $id = $request->getAttribute('id');
    //check param excaption

    $logger = \Twbot\Factory\LoggerFactory::getLogger(\Twbot\Enumerator\LoggerEnumerator::PROXY_LOGGER);
    $proxy = \Twbot\Repository\ProxyRepository::getProxyById($id);
    $proxyService = new \Twbot\Service\ProxyService($proxy, $logger);
    $result = $proxyService->ping() ? 'Worked!' : 'Nayyy..';

    return $response->write('Proxy tested! ' . $result);
});

$app->run();