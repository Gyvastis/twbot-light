<?php

namespace Twbot\Service;


use Abraham\TwitterOAuth\TwitterOAuth;
use Twbot\Entity\Account;
use Twbot\Entity\Message;

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
     * Post constructor.
     * @param TwitterOAuth $twitter
     * @param Account $account
     * @param Message $message
     */
    public function __construct(TwitterOAuth $twitter, Account $account, Message $message)
    {
        $this->twitter = $twitter;
        $this->account = $account;
        $this->message = $message;
    }


    public function send()
    {
        $this->twitter->post("statuses/update", [
            "status" => $this->getMessage()->getMessage()
        ]);
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