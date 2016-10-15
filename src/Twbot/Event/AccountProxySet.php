<?php

namespace Twbot\Event;


use Symfony\Component\EventDispatcher\Event;
use Twbot\Entity\Account;

class AccountProxySet extends Event
{
    /**
     * @var Account
     */
    protected $account;

    /**
     * @return Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param Account $account
     * @return AccountFound
     */
    public function setAccount($account)
    {
        $this->account = $account;

        return $this;
    }
}