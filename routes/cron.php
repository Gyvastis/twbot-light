<?php

require '../config.php';

global $container;
$app = new \Slim\App($container);

$app->get('/post/{username}', function ($request, $response, $args) use ($app) {
    $username = $request->getAttribute('username');

    $account = \Twbot\Repository\AccountRepository::getAccountByUsername($username);

    if(!$account){
        return $response->write('Account not found :(');
    }

    $cronService = new \Twbot\Service\CronService(new \Twbot\Repository\CronRepository());

    if($cronService->shouldPost($account)){

        $subRequestResponse = @file_get_contents(TWBOT_URL . "/routes/post.php/$username");

        if(!$subRequestResponse){
            return $response->write('Failed to post :(');
        }

        $cronService->justPosted($account);

        return $response->write($response);
    }

    return $response->write('No need to post');
});

$app->get('/test', function ($request, $response, $args) {
    return $response->write('test');
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

    var_dump($followerIds);die;
    if(empty($followerIds)){
        $logger->addCritical('No eligible followers :(');
    }

    $twitterFollowService = new \Twbot\Service\TwitterFollowService($twitter, $logger);
    foreach($followerIds as $followerId) {
        $twitterFollowService->followByUserId($followerId);
        $twitterFollowRepository->addUserIdUsed($followerId);
    }

    return $response->write('Followed ' . count($followerIds) . ' by ' . $account->getUsername());
});

$app->run();