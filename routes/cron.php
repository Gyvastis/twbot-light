<?php

require '../config.php';

global $container;
$app = new \Slim\App($container);

$app->get('/post', function ($request, $response, $args) use ($app) {
    $account = null;
    $accounts = \Twbot\Repository\AccountRepository::getAccounts();
    $cronService = new \Twbot\Service\CronService(new \Twbot\Repository\CronRepository());

    foreach($accounts as $uncheckedAccount){
        if($cronService->shouldPost($uncheckedAccount)){
            $account = $uncheckedAccount;

            break;
        }
    }

    if(!$account){
        return $response->write('No accounts needs posting :(');
    }

    $subRequestUrl = TWBOT_URL . "/routes/post.php/" . $account->getUsername();
    $subRequestResponse = @file_get_contents($subRequestUrl);

    if(!$subRequestResponse){
        return $response->write('Failed to post :(');
    }

    $cronService->justPosted($account);

    return $response->write($subRequestResponse);
});

$app->get('/fetch-followers/{take}', function ($request, $response, $args) {
    $take = (int)$request->getAttribute('take');
    $take = mt_rand($take / 2, $take);
    $take = round($take);

    $seederUsername = \Twbot\Factory\SeederFactory::getRandomSeederUsername();
    $subRequestUrl = TWBOT_URL . "/routes/follow.php/fetch-followers/$seederUsername/$take";

    $subRequestResponse = @file_get_contents($subRequestUrl);

    if(!$subRequestResponse){
        return $response->write('Failed to fetch followers :(');
    }

    return $response->write($subRequestResponse);
});

$app->get('/fetch-followers-details/{take}', function ($request, $response, $args) {
    $take = (int)$request->getAttribute('take');
    $take = mt_rand($take / 2, $take);
    $take = round($take);

    $subRequestUrl = TWBOT_URL . "/routes/follow.php/fetch-followers-details/$take";

    $subRequestResponse = @file_get_contents($subRequestUrl);

    if(!$subRequestResponse){
        return $response->write('Failed to fetch followers info :(');
    }

    return $response->write($subRequestResponse);
});

$app->get('/unfriend-followers', function ($request, $response, $args) {
    $account = null;
    $accounts = \Twbot\Repository\AccountRepository::getAccounts();
    $cronService = new \Twbot\Service\CronService(new \Twbot\Repository\CronRepository());

    foreach($accounts as $uncheckedAccount){
        if($cronService->shouldUnfriend($uncheckedAccount)){
            $account = $uncheckedAccount;

            break;
        }
    }

    if(!$account){
        return $response->write('No accounts needs posting :(');
    }

    $take = $account->getUnfriendAmountMax();
    $take = mt_rand($take / 2, $take);
    $take = round($take);

    $subRequestUrl = TWBOT_URL . "/routes/follow.php/unfriend-followers/" . $account->getUsername() . "/$take";
    $subRequestResponse = @file_get_contents($subRequestUrl);

    if(!$subRequestResponse){
        return $response->write('Failed to post :(');
    }

    $cronService->justUnfriended($account);

    return $response->write($subRequestResponse);
});

$app->run();