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

$app->get('/unfriend-followers/{username}/{take}', function ($request, $response, $args) {
    $username = $request->getAttribute('username');
    $take = (int)$request->getAttribute('take');

    $account = \Twbot\Repository\AccountRepository::getAccountByUsername($username);
    $twitter = \Twbot\Factory\TwitterFactory::getTwitterOAuth($account);
    $logger = \Twbot\Factory\TwitterFactory::getLogger();
    $twitterFollowService = new \Twbot\Service\TwitterFollowService($twitter, $logger);
    /**
     * @var \Twbot\Repository\TwitterFollowRepository $twitterFollowRepository
     */
    $twitterFollowRepository = getProvider('twitterFollowRepository');

    $followerIds = $twitterFollowService->getSeedUserFollowers($username, 1000);
    shuffle($followerIds);
    $followerIds = array_slice($followerIds, 1, $take);

    foreach($followerIds as $followerId) {
        $twitterFollowService->unfriendByUserId($followerId);
        $twitterFollowRepository->removeUserId($followerId);
    }

    return $response->write('Unfriended ' . count($followerIds) . ' users');
});

$app->run();