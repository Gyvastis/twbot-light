<?php

namespace Twbot\Entity;


class Proxy
{
    /**
     * @var string
     */
    protected $ipAddress;

    /**
     * @var integer
     */
    protected $port;

    /**
     * Proxy constructor.
     * @param string $ipAddress
     * @param int $port
     */
    public function __construct($ipAddress, $port)
    {
        $this->ipAddress = $ipAddress;
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @param string $ipAddress
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

}