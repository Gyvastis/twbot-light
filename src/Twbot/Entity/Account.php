<?php

namespace Twbot\Entity;


class Account
{
    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $phone;

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @var string
     */
    protected $accessSecret;

    /**
     * @var string
     */
    protected $consumerKey;

    /**
     * @var string
     */
    protected $consumerToken;

    /**
     * @var string
     */
    protected $mediaDir;

    /**
     * @var string
     */
    protected $proxyId;

    /**
     * @var Proxy
     */
    protected $proxy;

    /**
     * @var string
     */
    protected $messageCategoryName;

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getAccessSecret()
    {
        return $this->accessSecret;
    }

    /**
     * @param string $accessSecret
     */
    public function setAccessSecret($accessSecret)
    {
        $this->accessSecret = $accessSecret;
    }

    /**
     * @return string
     */
    public function getConsumerKey()
    {
        return $this->consumerKey;
    }

    /**
     * @param string $consumerKey
     */
    public function setConsumerKey($consumerKey)
    {
        $this->consumerKey = $consumerKey;
    }

    /**
     * @return string
     */
    public function getConsumerToken()
    {
        return $this->consumerToken;
    }

    /**
     * @param string $consumerToken
     */
    public function setConsumerToken($consumerToken)
    {
        $this->consumerToken = $consumerToken;
    }

    /**
     * @return string
     */
    public function getMediaDir()
    {
        return $this->mediaDir;
    }

    /**
     * @param string $mediaDir
     */
    public function setMediaDir($mediaDir)
    {
        $this->mediaDir = $mediaDir;
    }

    /**
     * @return string
     */
    public function getProxyId()
    {
        return $this->proxyId;
    }

    /**
     * @param string $proxyId
     */
    public function setProxyId($proxyId)
    {
        $this->proxyId = $proxyId;
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
     * @return string
     */
    public function getMessageCategoryName()
    {
        return $this->messageCategoryName;
    }

    /**
     * @param string $messageCategoryName
     */
    public function setMessageCategoryName($messageCategoryName)
    {
        $this->messageCategoryName = $messageCategoryName;
    }

}