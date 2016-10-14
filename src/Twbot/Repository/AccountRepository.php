<?php

namespace Twbot\Repository;

use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Yaml\Yaml;
use Twbot\Entity\Account;

class AccountRepository
{
    /**
     * @return array
     */
    public static function getAccountsArray()
    {
        return Yaml::parse(file_get_contents(ACCOUNTS_DATA_FILE));
    }

    /**
     * @return Account[]
     */
    public static function getAccounts()
    {
        $accessor = new PropertyAccessor(true);

        $accountsArray = self::getAccountsArray();
        $accounts = [];

        foreach($accountsArray as $accountArray){
            $account = new Account();

            foreach($accountArray as $accountKey => $accountValue) {
                $accountKey = preg_replace("/[^A-Za-z0-9 ]/", '', $accountKey);

                try {
                    $accessor->setValue($account, $accountKey, $accountValue);
                }
                catch(\Exception $ex){
                    var_dump($ex);
                    die;

                    //log error
                }
            }

            $accounts[] = $account;
        }

        return $accounts;
    }

    /**
     * @param string $username
     * @return null|Account
     */
    public static function getAccountByUsername($username)
    {
        $accounts = self::getAccounts();
        $foundAccount = null;

        foreach($accounts as $account){
            if($account->getUsername() == $username){
                $foundAccount = $account;

                break;
            }
        }

        return $foundAccount;
    }
}