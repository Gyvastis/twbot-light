<?php

// Create and configure Slim app
$config = ['settings' => [
    'addContentLengthHeader' => false,
]];

$app = new \Slim\App($config);

$app->get('/', function ($request, $response, $args) {
    return $response->write("Hello " . $args['name']);
});

$app->run();