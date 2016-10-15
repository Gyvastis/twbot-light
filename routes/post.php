<?php

require '../config.php';

global $container;
$app = new \Slim\App($container);

// - - -

$app->get('/', function ($request, $response, $args) {
    $this->logger->addInfo("Poster Home");

    return $response->write("Post Job!");
});

$app->get('/ping-proxy/{id}', function ($request, $response, $args) {
    $id = $request->getAttribute('id');
    //check param excaption

    $logger = \Twbot\Factory\LoggerFactory::getLogger(\Twbot\Enumerator\LoggerEnumerator::PROXY_LOGGER);

    $proxy = \Twbot\Repository\ProxyRepository::getProxyById($id);
    $proxyService = new \Twbot\Service\ProxyService($proxy, $logger);
    $result = $proxyService->ping() ? 'Worked!' : 'Nayyy..';

    return $response->write('Proxy tested! ' . $result);
});

$app->get('/{username}', function ($request, $response, $args) {
    $username = $request->getAttribute('username');
    //check param excaption

    $logger = \Twbot\Factory\LoggerFactory::getLogger(\Twbot\Enumerator\LoggerEnumerator::POST_LOGGER);
    $account = \Twbot\Repository\AccountRepository::getAccountByUsername($username);
    $twitter = \Twbot\Factory\TwitterFactory::getTwitterOAuth($account);
    $image = \Twbot\Factory\ImageFactory::getRandomImage($account);

    $message = new \Twbot\Entity\Message();
    $message->setMessage('Test first message');

    $postService = new \Twbot\Service\PostService($twitter, $account, $message, $image, $logger);
    $postService->send();

    return $response->write("Posted to: $username");
});

$app->run();