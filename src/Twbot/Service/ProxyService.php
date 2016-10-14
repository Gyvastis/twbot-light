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
     * @param Proxy $proxy
     * @param Logger $logger
     */
    public function __construct(Proxy $proxy, Logger $logger)
    {
        $this->proxy = $proxy;
        $this->logger = $logger;
    }

    /**
     * @return boolean
     */
    public function ping()
    {
        if($fp = @fsockopen(
            $this->getProxy()->getIpAddress(),
            $this->getProxy()->getPort(),
            $errorCode,
            $error,
            self::PROXY_TIMEOUT_MAX_SECONDS
        )){
            @fclose($fp);

            return true;
        }
        else{
            @fclose($fp);

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