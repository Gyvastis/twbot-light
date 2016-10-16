<?php

namespace Twbot\Service;


use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException;
use Monolog\Logger;
use Twbot\Entity\Image;

class TwitterFollowService
{
    /**
     * @var TwitterOAuth
     */
    protected $twitter;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * TwitterService constructor.
     * @param TwitterOAuth $twitter
     * @param Logger $logger
     */
    public function __construct(TwitterOAuth $twitter, Logger $logger)
    {
        $this->twitter = $twitter;
        $this->logger = $logger;
    }

    /**
     * @param string $username
     * @param int $count
     * @return array|null
     */
    public function getSeedUserFollowers($username, $count = 1000)
    {
        try{
            $response = $this->getTwitter()->get('followers/ids', array(
                'screen_name' => $username,
                'stringify_ids' => true,
                'count' => $count
            ));
        }
        catch(TwitterOAuthException $ex){
            $this->getLogger()->addCritical($ex->getMessage());
        }

        return isset($response->ids) ? $response->ids : null;
    }

    /**
     * @param string $userId
     */
    public function followByUserId($userId)
    {
        try{
            $this->getTwitter()->post('friendships/create', array(
                'user_id' => $userId,
                'follow' => true
            ));
        }
        catch(TwitterOAuthException $ex){
            $this->getLogger()->addCritical($ex->getMessage());
        }
    }

    /**
     * @param string $userId
     */
    public function unfriendByUserId($userId)
    {
        try{
            $this->getTwitter()->post('friendships/destroy', array(
                'user_id' => $userId
            ));
        }
        catch(TwitterOAuthException $ex){
            $this->getLogger()->addCritical($ex->getMessage());
        }
    }

    /**
     * @param array $userIds
     * @return array|object
     */
    public function fetchUserInfoByUserIds($userIds)
    {
        try{
            $userInfos = $this->getTwitter()->post('users/lookup', array(
                'user_id' => implode(',', $userIds)
            ));
        }
        catch(TwitterOAuthException $ex){
            $this->getLogger()->addCritical($ex->getMessage());
        }

        return $userInfos;
    }

    /**
     * @return TwitterOAuth
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * @param TwitterOAuth $twitter
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * @return Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param Logger $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

}