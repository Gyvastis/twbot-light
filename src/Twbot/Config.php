<?php

namespace Twbot;

class Config
{
    public static function getAccounts()
    {
        return Yaml::parse(file_get_contents('/path/to/file.yml'));
    }
}