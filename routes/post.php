<?php

require '../config.php';

$config = ['settings' => [
    'addContentLengthHeader' => false,
]];

$app = new \Slim\App($config);

$app->get('/', function ($request, $response, $args) {
    return $response->write("Post Job!");
});

$app->get('/{username}', function ($request, $response, $args) {
    $username = $request->getAttribute('username');

    return $response->write("Posted to: $username");
});

$app->run();