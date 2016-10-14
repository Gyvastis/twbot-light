<?php
/**
 * Created by PhpStorm.
 * User: vaidas
 * Date: 14/10/2016
 * Time: 20:13
 */

namespace Twbot;


use Abraham\TwitterOAuth\TwitterOAuth;
use Twbot\Entity\Account;

class Factory
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
            $account->getAccountSecret()
        );
    }
}