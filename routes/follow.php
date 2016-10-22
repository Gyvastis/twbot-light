<?php

require '../config.php';

global $container;
$app = new \Slim\App($container);

$app->get('/fetch-followers/{username}/{take}', function ($request, $response, $args) {
    $username = $request->getAttribute('username');
    $take = (int)$request->getAttribute('take');

    $account = \Twbot\Repository\AccountRepository::getAccountByUsername($username);
    $twitter = \Twbot\Factory\TwitterFactory::getTwitterOAuth($account);
    $logger = \Twbot\Factory\TwitterFactory::getLogger();
    $twitterFollowService = new \Twbot\Service\TwitterFollowService($twitter, $logger);

    $followerIds = $twitterFollowService->getSeedUserFollowers($username, $take);

    /**
     * @var \Twbot\Repository\TwitterFollowRepository $twitterFollowRepository
     */
    $twitterFollowRepository = getProvider('twitterFollowRepository');
    $twitterFollowRepository->addUserIdFreeBulk($username, $followerIds);

    return $response->write('Fetched ' . count($followerIds) . ' from ' . $username);
});

$app->get('/fetch-followers-details', function ($request, $response, $args) {
    /**
     * @var \Twbot\Repository\TwitterFollowRepository $twitterFollowRepository
     */
    $twitterFollowRepository = getProvider('twitterFollowRepository');

    $account = \Twbot\Factory\AccountFactory::getRandomAccount();
    $twitter = \Twbot\Factory\TwitterFactory::getTwitterOAuth($account);
    $logger = \Twbot\Factory\TwitterFactory::getLogger();
    $twitterFollowService = new \Twbot\Service\TwitterFollowService($twitter, $logger);

    $userIds = $twitterFollowRepository->getUsersWithoutInfo(100);
    $userInfos = $twitterFollowService->fetchUserInfoByUserIds($userIds);

    $twitterFollowRepository->saveUserInfos($userInfos);

    return $response->write('Follower info fetched for ' . count($userIds) . ' users');
});

$app->run();