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
     * @param TwitterOAuth $twitter
     * @param Account $account
     * @param Message $message
     * @param Image $image
     * @param Logger $logger
     */
    public function __construct(TwitterOAuth $twitter, Account $account, Message $message, Image $image, Logger $logger)
    {
        $this->account = $account;
        $this->message = $message;
        $this->twitter = $twitter;
        $this->logger = $logger;
    }

    public function send()
    {
        $this->twitter->post("statuses/update", [
            "status" => $this->getMessage()->getMessage(),
            'media_ids' => $this->uploadMedia()
        ]);

        if ($this->twitter->getLastHttpCode() == 200) {
            //handle exception
        }

        // log image used, media dir, message, ..., generate tracker id?
    }

    /**
     * @return string
     */
    public function uploadMedia()
    {
        $media = $this->twitter->upload('media/upload', ['media' => $this->getImage()->getImagePath()]);

        // handle error

        return $media->media_id_string;
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