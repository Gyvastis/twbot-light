<?php

require '../config.php';

global $container;
$app = new \Slim\App($container);

$app->get('/monitor', function ($request, $response, $args) {
    return $response->write("Up and running");
});

$app->run();