<?php

namespace Twbot;

use Symfony\Component\Yaml\Yaml;

class Config
{
    public static function getAccounts()
    {
        return Yaml::parse(file_get_contents(ACCOUNTS_DATA_FILE));
    }

    public static function getAccountByUsername($username)
    {
        $accounts = self::getAccounts();
        $foundAccount = null;

        foreach($accounts as $account){
            if($account['username'] == $username){
                $foundAccount = $account;

                break;
            }
        }

        return $foundAccount;
    }
}