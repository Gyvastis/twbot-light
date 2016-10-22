<?php

require '../config.php';

global $container;
$app = new \Slim\App($container);

$app->get('/fetch-followers/{seeder-username}/{take}', function ($request, $response, $args) {
    $seederUsername = $request->getAttribute('seeder-username');
    $take = (int)$request->getAttribute('take');

    $account = \Twbot\Factory\AccountFactory::getRandomAccount();
    $twitter = \Twbot\Factory\TwitterFactory::getTwitterOAuth($account);
    $logger = \Twbot\Factory\TwitterFactory::getLogger();
    $twitterFollowService = new \Twbot\Service\TwitterFollowService($twitter, $logger);

    $followerIds = $twitterFollowService->getSeedUserFollowers($seederUsername, $take);

    /**
     * @var \Twbot\Repository\TwitterFollowRepository $twitterFollowRepository
     */
    $twitterFollowRepository = getProvider('twitterFollowRepository');
    $twitterFollowRepository->addUserIdFreeBulk($username, $followerIds);

    return $response->write('Fetched ' . count($followerIds) . ' from ' . $username);
});

$app->get('/fetch-followers-details/{take}', function ($request, $response, $args) {
    $take = (int)$request->getAttribute('take');

    /**
     * @var \Twbot\Repository\TwitterFollowRepository $twitterFollowRepository
     */
    $twitterFollowRepository = getProvider('twitterFollowRepository');

    $account = \Twbot\Factory\AccountFactory::getRandomAccount();
    $twitter = \Twbot\Factory\TwitterFactory::getTwitterOAuth($account);
    $logger = \Twbot\Factory\TwitterFactory::getLogger();
    $twitterFollowService = new \Twbot\Service\TwitterFollowService($twitter, $logger);

    $userIds = $twitterFollowRepository->getUsersWithoutInfo($take);
    $userInfos = $twitterFollowService->fetchUserInfoByUserIds($userIds);

    $twitterFollowRepository->saveUserInfos($userInfos);

    return $response->write('Follower info fetched for ' . count($userIds) . ' users');
});

$app->run();