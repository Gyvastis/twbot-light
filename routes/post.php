<?php

require '../config.php';

$config = ['settings' => [
    'addContentLengthHeader' => false,
//    'displayErrorDetails' => true,
]];

$app = new \Slim\App($config);

$container = $app->getContainer();
//$container['logger'] = function($c) {
//    return \Twbot\Factory\LoggerFactory::getLogger(\Twbot\Enumerator\LoggerEnumerator::POST_LOGGER);
//};
$container['errorHandler'] = function ($c) {
    return \Twbot\Factory\LoggerFactory::getDefaultErrorHandler();
};

// - - -

$app->get('/', function ($request, $response, $args) {
//    $this->logger->addInfo("Poster Home");

    return $response->write("Post Job!");
});

$app->get('/{username}', function ($request, $response, $args) {
    $username = $request->getAttribute('username');
    $account = \Twbot\Repository\AccountRepository::getAccountByUsername($username);

    $message = new \Twbot\Entity\Message();
    $message->setMessage('Test first message');

    $post = new \Twbot\Service\PostService(
        \Twbot\Factory\TwitterFactory::getTwitterOAuth($account),
        $account,
        $message,
        \Twbot\Factory\ImageFactory::getRandomImage($account),
        \Twbot\Factory\LoggerFactory::getLogger(\Twbot\Enumerator\LoggerEnumerator::POST_LOGGER)
    );
    $post->send();

    return $response->write("Posted to: $username");
});

$app->run();