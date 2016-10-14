<?php

require '../config.php';

$config = ['settings' => [
    'addContentLengthHeader' => false,
//    'displayErrorDetails' => true,
]];

$app = new \Slim\App($config);

$container = $app->getContainer();
$container['logger'] = function($c) {
    return \Twbot\Factory\LoggerFactory::getLogger('post');
};
$container['errorHandler'] = function ($c) {
    return \Twbot\Factory\LoggerFactory::getDefaultErrorHandler();
};

// - - -

$app->get('/', function ($request, $response, $args) {
    $this->logger->addInfo("Poster Home");

    return $response->write("Post Job!");
});

$app->get('/{username}', function ($request, $response, $args) {
    $username = $request->getAttribute('username');

    $logger = \Twbot\Factory\LoggerFactory::getLogger('post');
    $account = \Twbot\Repository\AccountRepository::getAccountByUsername($username);
    $twitter = \Twbot\Factory\TwitterFactory::getTwitterOAuth($account);

    $message = new \Twbot\Entity\Message();
    $message->setMessage('Test first message');

    $post = new \Twbot\Service\Post($twitter, $account, $message, $logger);
    $post->send();

    $this->logger->addInfo("Poster");

    return $response->write("Posted to: $username");
});

$app->run();