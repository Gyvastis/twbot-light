<?php

require '../config.php';

global $container;
$app = new \Slim\App($container);

$app->get('/', function ($request, $response, $args) {
    $this->logger->addInfo("Poster Home");

    return $response->write("Post Job!");
});

$app->get('/{username}', function ($request, $response, $args) {
    $username = $request->getAttribute('username');
    //check param excaption

    $logger = \Twbot\Factory\LoggerFactory::getLogger(\Twbot\Enumerator\LoggerEnumerator::POST_LOGGER);
    $account = \Twbot\Repository\AccountRepository::getAccountByUsername($username);
    $twitter = \Twbot\Factory\TwitterFactory::getTwitterOAuth($account);
    $image = \Twbot\Factory\ImageFactory::getRandomImage($account);
    $message = \Twbot\Factory\MessageFactory::getRandomMessage($account->getMessageCategoryName());

    $postService = new \Twbot\Service\PostService($twitter, $account, $message, $image, $logger);
    $postService->send();

    return $response->write("Posted to: $username");
});

$app->run();