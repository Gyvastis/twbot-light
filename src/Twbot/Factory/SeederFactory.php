<?php

namespace Twbot\Factory;


use Symfony\Component\Yaml\Yaml;

class SeederFactory
{
    /**
     * @return array
     */
    public static function getSeederDataArray()
    {
        return Yaml::parse(file_get_contents(SEEDERS_DATA_FILE));
    }

    /**
     * @return Proxy[]
     */
    public static function getSeederUsernames()
    {
        return self::getSeederDataArray()['seeder_usernames'];
    }

    /**
     * @return null|string
     */
    public static function getRandomSeederUsername()
    {
        $seeders = self::getSeederUsernames();

        return !empty($seeders) ? $seeders[array_rand($seeders)] : null;
    }
}