<?php

require '../config.php';

global $container;
$app = new \Slim\App($container);

$app->get('/test-cron/{username}', function ($request, $response, $args) {
    $username = $request->getAttribute('username');

    $account = \Twbot\Repository\AccountRepository::getAccountByUsername($username);
    $cronService = new \Twbot\Service\CronService(new \Twbot\Repository\CronRepository());

    if($cronService->shouldPost($account)){
        $cronService->justPosted($account);

        return $response->write('Posted!');
    }

    return $response->write('No need to post');
});

$app->run();