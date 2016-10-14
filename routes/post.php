<?php

require '../config.php';

$config = ['settings' => [
    'addContentLengthHeader' => false,
]];

$app = new \Slim\App($config);

$container = $app->getContainer();
$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('post');
    $logger->pushHandler(new \Monolog\Handler\StreamHandler(LOG_DIR . "post.log"));

    return $logger;
};

$app->get('/', function ($request, $response, $args) {
    return $response->write("Post Job!");
});

$app->get('/{username}', function ($request, $response, $args) {
    $username = $request->getAttribute('username');

    /**
     * @var \Monolog\Logger $this->logger
     */
    $this->logger->addInfo("Something interesting happened");

    return $response->write("Posted to: $username");
});

$app->run();