<?php

namespace Twbot\Factory;


use Twbot\Enumerator\LoggerEnumerator;

class MessageFactory
{
    /**
     * @return \Monolog\Logger
     */
    public static function getLogger()
    {
        return LoggerFactory::getLogger(LoggerEnumerator::MESSAGE_LOGGER);
    }
}