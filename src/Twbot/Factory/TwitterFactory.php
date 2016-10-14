<?php

namespace Twbot\Factory;


use Abraham\TwitterOAuth\TwitterOAuth;
use Twbot\Entity\Account;
use Twbot\Enumerator\LoggerEnumerator;

class TwitterFactory
{
    /**
     * @return \Monolog\Logger
     */
    public static function getLogger()
    {
        return LoggerFactory::getLogger(LoggerEnumerator::TWITTER_LOGGER);
    }

    /**
     * @param Account $account
     * @return TwitterOAuth
     */
    public static function getTwitterOAuth($account)
    {
        return new TwitterOAuth(
            $account->getConsumerKey(),
            $account->getConsumerToken(),
            $account->getAccessToken(),
            $account->getAccessSecret()
        );
    }
}