<?php

namespace Twbot\Service;


use Abraham\TwitterOAuth\TwitterOAuth;
use Monolog\Logger;
use Twbot\Entity\Account;
use Twbot\Entity\Image;
use Twbot\Entity\Message;

class PostService
{
    /**
     * @var Account
     */
    protected $account;

    /**
     * @var Message
     */
    protected $message;

    /**
     * @var TwitterOAuth
     */
    protected $twitter;

    /**
     * @var Image
     */
    protected $image;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * PostService constructor.
     * @param Account $account
     * @param Message $message
     * @param TwitterOAuth $twitter
     * @param Image $image
     * @param Logger $logger
     */
    public function __construct(TwitterOAuth $twitter, Account $account, Message $message, Image $image, Logger $logger)
    {
        $this->twitter = $twitter;
        $this->account = $account;
        $this->message = $message;
        $this->image = $image;
        $this->logger = $logger;
    }


    public function send()
    {
        $this->getTwitter()->post("statuses/update", [
            "status" => $this->getMessage()->getMessage(),
            'media_ids' => $this->uploadMedia()
        ]);

        if (!$this->getTwitter()->getLastHttpCode() == 200) {
            //handle exception
        }

        // log image used, media dir, message, ..., generate tracker id?
    }

    /**
     * @return string
     */
    public function uploadMedia()
    {
        $media = $this->getTwitter()->upload('media/upload', ['media' => $this->getImage()->getImagePath()]);

        if (!$this->getTwitter()->getLastHttpCode() == 200) {
            //handle exception
        }

        return isset($media->media_id_string) ? $media->media_id_string : false;
    }

    /**
     * @return Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return TwitterOAuth
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }

}