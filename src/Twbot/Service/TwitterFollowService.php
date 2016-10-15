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
    public function getSeedUserFollowers($username, $count = 5000)
    {
        try{
            $response = $this->twitter->get('followers/ids', array(
                'screen_name' => $username,
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
    public function unfriendByUserId($userId)
    {
        try{
            $this->twitter->post('friendships/destroy', array(
                'user_id' => $userId
            ));
        }
        catch(TwitterOAuthException $ex){
            $this->getLogger()->addCritical($ex->getMessage());
        }
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