<?php

namespace Twbot\Factory;


use Abraham\TwitterOAuth\TwitterOAuth;
use Twbot\Entity\Account;
use Twbot\Enumerator\EventEnumerator;
use Twbot\Enumerator\LoggerEnumerator;
use Twbot\Event\AccountProxySet;

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

        $twitterOAuth->setTimeouts(10, 15);

        if($account->getProxy()){
            $twitterOAuth->setProxy([
                'CURLOPT_PROXY' => $account->getProxy()->getIpAddress(),
                'CURLOPT_PROXYPORT' => $account->getProxy()->getPort(),
                'CURLOPT_PROXYUSERPWD' => '',
            ]);

            getProvider('dispatcher')->dispatch(EventEnumerator::ACCOUNT_PROXY_SET_EVENT, (new AccountProxySet())->setAccount($account));
        }

        return $twitterOAuth;
    }
}