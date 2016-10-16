<?php

require '../config.php';

global $container;
$app = new \Slim\App($container);

$app->get('/get-followers/{username}', function ($request, $response, $args) {
    $username = $request->getAttribute('username');

    $account = \Twbot\Factory\AccountFactory::getRandomAccount();
    $twitter = \Twbot\Factory\TwitterFactory::getTwitterOAuth($account);
    $logger = \Twbot\Factory\TwitterFactory::getLogger();
    $twitterFollowService = new \Twbot\Service\TwitterFollowService($twitter, $logger);

    $followerIds = $twitterFollowService->getSeedUserFollowers($username);

    return $response->write(var_export($followerIds));
});


$app->get('/test-follow-used', function ($request, $response, $args) {
    /**
     * @var \Twbot\Repository\TwitterFollowRepository $twitterFollowRepository
     */
    $twitterFollowRepository = getProvider('twitterFollowRepository');

    $twitterFollowRepository->addUserIdUsed('test1', '123123');
});

$app->run();