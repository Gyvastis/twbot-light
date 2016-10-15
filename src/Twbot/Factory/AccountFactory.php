<?php

namespace Twbot\Factory;


use Twbot\Enumerator\LoggerEnumerator;
use Twbot\Repository\AccountRepository;

class AccountFactory
{
    /**
     * @return \Monolog\Logger
     */
    public static function getLogger()
    {
        return LoggerFactory::getLogger(LoggerEnumerator::ACCOUNT_LOGGER);
    }

    /**
     * @return null|\Twbot\Entity\Account
     */
    public static function getRandomAccount()
    {
        $accounts = AccountRepository::getAccounts();

        return !empty($accounts) ? $accounts[array_rand($accounts)] : null;
    }
}