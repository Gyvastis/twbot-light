<?php

namespace Twbot;

use Symfony\Component\Yaml\Yaml;

class Config
{
    public static function getAccounts()
    {
        return Yaml::parse(file_get_contents(ACCOUNTS_DATA_FILE));
    }
}