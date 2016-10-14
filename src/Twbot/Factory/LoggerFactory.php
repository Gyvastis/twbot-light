<?php
/**
 * Created by PhpStorm.
 * User: vaidas
 * Date: 15/10/2016
 * Time: 01:29
 */

namespace Twbot\Factory;

use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Twbot\Core\Error;


class LoggerFactory
{
    /**
     * @return Logger
     */
    public static function getDefaultErrorHandler()
    {
        $logger = self::getLogger('default');

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