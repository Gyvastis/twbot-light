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
        $twitterOAuth = new TwitterOAuth(
            $account->getConsumerKey(),
            $account->getConsumerToken(),
            $account->getAccessToken(),
            $account->getAccessSecret()
        );

//        $twitterOAuth->setTimeouts(10, 15);

        if($account->getProxy()){
            $twitterOAuth->setProxy([
                'CURLOPT_PROXY' => $account->getProxy()->getIpAddress(),
                'CURLOPT_PROXYPORT' => $account->getProxy()->getPort(),
                'CURLOPT_PROXYUSERPWD' => '',
            ]);
        }

        return $twitterOAuth;
    }
}