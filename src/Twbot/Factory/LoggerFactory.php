<?php

namespace Twbot\Factory;

use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Twbot\Core\Error;
use Twbot\Enumerator\LoggerEnumerator;


class LoggerFactory
{
    /**
     * @return Logger
     */
    public static function getDefaultErrorHandler()
    {
        $logger = self::getLogger(LoggerEnumerator::ERROR_LOGGER);

        return new Error($logger);
    }

    /**
     * @param string $logName
     * @return Logger
     */
    public static function getLogger($logName)
    {
        $logger = new Logger($logName);

        $handler = new RotatingFileHandler(LOG_DIR . "$logName.log");
        $handler->setFormatter(new JsonFormatter());

        $logger->pushHandler($handler);

        return $logger;
    }
}