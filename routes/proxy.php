<?php

require '../config.php';

global $container;
$app = new \Slim\App($container);

$app->get('/ping-proxy/{id}', function ($request, $response, $args) {
    $id = $request->getAttribute('id');
    //check param excaption

    $proxy = \Twbot\Repository\ProxyRepository::getProxyById($id);

    /**
     * @var \Twbot\Service\ProxyService $proxyService
     */
    $proxyService = getProvider('proxyService');
    $proxyService->setProxy($proxy);

    $result = $proxyService->ping() ? 'Worked!' : 'Nayyy..';

    return $response->write('Proxy tested! ' . $result);
});

$app->run();