<?php

require '../config.php';

global $container;
$app = new \Slim\App($container);

$app->get('/test-cron/{username}', function ($request, $response, $args) {
    $username = $request->getAttribute('username');

    $account = \Twbot\Repository\AccountRepository::getAccountByUsername($username);
    $cronService = new \Twbot\Service\CronService(new \Twbot\Repository\CronRepository());
    var_dump($cronService->shouldPost($account), $account->getUsername());

    return $response->write('cron test');
});

$app->run();