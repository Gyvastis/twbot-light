<?php

namespace Twbot\Service;


use Monolog\Logger;
use Twbot\Entity\Proxy;

class ProxyService
{
    const PROXY_TIMEOUT_MAX_SECONDS = 2;

    /**
     * @var Proxy $proxy
     */
    protected $proxy;

    /**
     * @var Logger $logger
     */
    protected $logger;

    /**
     * ProxyService constructor.
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return boolean
     */
    public function ping()
    {
        $startTime = microtime(true);

        if($fp = @fsockopen(
            $this->getProxy()->getIpAddress(),
            $this->getProxy()->getPort(),
            $errorCode,
            $error,
            self::PROXY_TIMEOUT_MAX_SECONDS
        )){
            @fclose($fp);

            $timeDifference = microtime(true) - $startTime;
            $timeDifference = round($timeDifference, 3);
            $this->getLogger()->addInfo("Proxy {$this->getProxy()} responded in {$timeDifference}s");

            return true;
        }
        else{
            @fclose($fp);

            $this->getLogger()->addCritical("Proxy {$this->getProxy()} is unreachable.");

            return false;
        }
    }

    /**
     * @return Proxy
     */
    public function getProxy()
    {
        return $this->proxy;
    }

    /**
     * @param Proxy $proxy
     */
    public function setProxy($proxy)
    {
        $this->proxy = $proxy;
    }

    /**
     * @return Logger
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param Logger $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

}