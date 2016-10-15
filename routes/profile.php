<?php

require '../config.php';

global $container;
$app = new \Slim\App($container);

$app->group('/image-rotate', function () {
    $this->get('/profile/{username}', function ($request, $response, $args) {
        $username = $request->getAttribute('username');

        $account = \Twbot\Repository\AccountRepository::getAccountByUsername($username);
        $image = \Twbot\Factory\ImageFactory::getRandomImage($account);
        $twitter = \Twbot\Factory\TwitterFactory::getTwitterOAuth($account);
        $logger = \Twbot\Factory\TwitterFactory::getLogger();

        $twitterUploadService = new \Twbot\Service\TwitterUploadService($twitter, $logger);
        $twitterUploadService->uploadProfileImage($image);

        return $response->write("Profile $username Rotate!");
    });

    $this->get('/background/{username}', function ($request, $response, $args) {
        $username = $request->getAttribute('username');

        $account = \Twbot\Repository\AccountRepository::getAccountByUsername($username);
        $image = \Twbot\Factory\ImageFactory::getRandomImage($account);
        $twitter = \Twbot\Factory\TwitterFactory::getTwitterOAuth($account);
        $logger = \Twbot\Factory\TwitterFactory::getLogger();

        $twitterUploadService = new \Twbot\Service\TwitterUploadService($twitter, $logger);
        $twitterUploadService->uploadProfileImage($image);

        return $response->write("Background $username Rotate!");
    });
});

$app->run();