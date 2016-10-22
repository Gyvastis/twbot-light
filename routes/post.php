<?php

require '../config.php';

global $container;
$app = new \Slim\App($container);

$app->get('/{username}', function ($request, $response, $args) {
    $username = $request->getAttribute('username');

    $account = \Twbot\Repository\AccountRepository::getAccountByUsername($username);
    $logger = \Twbot\Factory\LoggerFactory::getLogger(\Twbot\Enumerator\LoggerEnumerator::POST_LOGGER);
    $twitter = \Twbot\Factory\TwitterFactory::getTwitterOAuth($account);
    $image = \Twbot\Factory\ImageFactory::getRandomImage($account);
    $message = \Twbot\Factory\MessageFactory::getRandomMessageWithTags($account->getMessageCategoryName(), 3);

    $postService = new \Twbot\Service\PostService($twitter, $account, $message, $image, $logger);
    $postService->send();

    return $response->write("Posted to: $username");
});

$app->run();