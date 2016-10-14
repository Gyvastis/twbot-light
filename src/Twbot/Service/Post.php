<?php

namespace Twbot\Service;


use Abraham\TwitterOAuth\TwitterOAuth;
use Monolog\Logger;
use Twbot\Entity\Account;
use Twbot\Entity\Message;
use Twbot\Factory\ImageFactory;

class Post
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
     * @var Logger
     */
    protected $logger;

    /**
     * Post constructor.
     * @param TwitterOAuth $twitter
     * @param Account $account
     * @param Message $message
     * @param Logger $logger
     */
    public function __construct(TwitterOAuth $twitter, Account $account, Message $message, Logger $logger)
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
        $randomImage = ImageFactory::getRandomImage($this->getAccount());
        $media = $this->twitter->upload('media/upload', ['media' => $randomImage]);

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
     * @param Account $account
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }

    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param Message $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
}