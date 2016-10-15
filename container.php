<?php

global $container;

$container = new \Slim\Container([
    'displayErrorDetails' => true,
]);

$container['errorHandler'] = function ($c) {
    return \Twbot\Factory\LoggerFactory::getDefaultErrorHandler();
};