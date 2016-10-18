<?php

namespace Twbot\Factory;


use Twbot\Enumerator\LoggerEnumerator;
use Twbot\Repository\MessageRepository;

class MessageFactory
{
    /**
     * @return \Monolog\Logger
     */
    public static function getLogger()
    {
        return LoggerFactory::getLogger(LoggerEnumerator::MESSAGE_LOGGER);
    }

    /**
     * @param string $categoryName
     * @return null|\Twbot\Entity\Message
     */
    public static function getRandomMessage($categoryName)
    {
        $messages = MessageRepository::getMessages($categoryName);

        return !empty($messages) ? $messages[array_rand($messages)] : null;
    }

    /**
     * @param string s$categoryName
     * @param int $tagCount
     * @return null|\Twbot\Entity\Message
     */
    public static function getRandomMessageWithTags($categoryName, $tagCount = 5)
    {
        $randomMessage = self::getRandomMessage($categoryName);

        $tags = MessageRepository::getTags($categoryName);

        if(!empty($tags)){
            shuffle($tags);

            $tags = array_slice($tags, 0, $tagCount);
            $randomMessage->setTags($tags);
        }

        return $randomMessage;
    }
}