<?php

namespace Twbot\Service;


use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\TwitterOAuthException;
use Monolog\Logger;

class TwitterService
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
     * @param string $imagePath
     */
    public function uploadProfileImage($imagePath)
    {
        try {
            $this->getTwitter()->post('account/update_profile_image', array(
                "image" => base64_encode(file_get_contents($imagePath)))
            ));
        }
        catch(TwitterOAuthException $ex){
            $this->getLogger()->addCritical($ex->getMessage());
        }
    }

    /**
     * @param string $imagePath
     */
    public function uploadBackgroundImage($imagePath)
    {
        try {
            $this->getTwitter()->post('account/update_profile_banner', array(
                "banner" => base64_encode(file_get_contents($imagePath)))
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