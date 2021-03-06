<?php

namespace Twbot\Repository;

use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Yaml\Yaml;
use Twbot\Entity\Account;
use Twbot\Enumerator\EventEnumerator;
use Twbot\Event\AccountFound;

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
     * @param boolean $skipDisabled
     * @return Account[]
     */
    public static function getAccounts($skipDisabled = true)
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

            if($skipDisabled && $account->isDisabled()){
                continue;
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

                getProvider('dispatcher')->dispatch(EventEnumerator::ACCOUNT_FOUND_EVENT, (new AccountFound())->setAccount($account));

                break;
            }
        }

        return $foundAccount;
    }
}