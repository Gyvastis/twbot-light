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
     * @param $categoryName
     * @return null|\Twbot\Entity\Message
     */
    public static function getRandomMessage($categoryName)
    {
        $messages = MessageRepository::getMessages($categoryName);

        return !empty($messages) ? $messages[array_rand($messages)] : null;
    }
}