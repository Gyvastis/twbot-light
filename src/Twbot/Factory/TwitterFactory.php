<?php
/**
 * Created by PhpStorm.
 * User: vaidas
 * Date: 15/10/2016
 * Time: 01:30
 */

namespace Twbot\Factory;


use Abraham\TwitterOAuth\TwitterOAuth;
use Twbot\Entity\Account;

class TwitterFactory
{
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