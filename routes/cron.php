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

$app->get('/test-take-follower', function ($request, $response, $args) {

    $account = \Twbot\Factory\AccountFactory::getRandomAccount();
    $twitter = \Twbot\Factory\TwitterFactory::getTwitterOAuth($account);
    $logger = \Twbot\Factory\TwitterFactory::getLogger();

    /**
     * @var \Twbot\Repository\TwitterFollowRepository $twitterFollowRepository
     */
    $twitterFollowRepository = getProvider('twitterFollowRepository');
    $followerIds = $twitterFollowRepository->getEligibleToBeFollowed();

    var_dump($followerIds);

    return $response->write('No followers :(');
});

$app->run();