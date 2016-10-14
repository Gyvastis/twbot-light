<?php

namespace Twbot\Factory;


use Twbot\Entity\Account;
use Twbot\Entity\Image;
use Twbot\Enumerator\LoggerEnumerator;

class ImageFactory
{
    /**
     * @return \Monolog\Logger
     */
    public static function getLogger()
    {
        return LoggerFactory::getLogger(LoggerEnumerator::IMAGE_LOGGER);
    }

    /**
     * @param Account $account
     * @return string
     */
    public static function getRandomImage($account)
    {
        // check if folder exists

        $images = glob(MEDIA_DIR . $account->getMediaDir() . '/*.{jpg,gif,png}', GLOB_BRACE);
        $imagePath = $images[array_rand($images)];

        return new Image($imagePath);
    }
}