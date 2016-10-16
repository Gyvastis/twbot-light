<?php

require '../config.php';

global $container;
$app = new \Slim\App($container);

$app->get('/test-cron/{username}', function ($request, $response, $args) {
    $username = $request->getAttribute('username');

    $cronRepo = new \Twbot\Repository\CronRepository();
    $jobDate = $cronRepo->getJobDate($username, \Twbot\Enumerator\CronEnumerator::POST_JOB);

    return $response->write('cron test');
});

$app->run();