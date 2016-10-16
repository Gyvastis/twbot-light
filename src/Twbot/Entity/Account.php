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
     * @var boolean
     */
    protected $disabled;

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
     * @var integer
     */
    protected $postIntervalMinutes;

    /**
     * @var integer
     */
    protected $unfriendIntervalMinutes;

    /**
     * @var integer
     */
    protected $unfriendAmountMax;

    /**
     * @var integer
     */
    protected $followIntervalMinutes;

    /**
     * @var integer
     */
    protected $followAmountMax;

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
     * @return boolean
     */
    public function isDisabled()
    {
        return $this->disabled;
    }

    /**
     * @param boolean $disabled
     */
    public function setDisabled($disabled)
    {
        $this->disabled = (bool)$disabled;
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

    /**
     * @return int
     */
    public function getPostIntervalMinutes()
    {
        return $this->postIntervalMinutes;
    }

    /**
     * @param int $postIntervalMinutes
     */
    public function setPostIntervalMinutes($postIntervalMinutes)
    {
        $this->postIntervalMinutes = $postIntervalMinutes;
    }

    /**
     * @return int
     */
    public function getUnfriendIntervalMinutes()
    {
        return $this->unfriendIntervalMinutes;
    }

    /**
     * @param int $unfriendIntervalMinutes
     */
    public function setUnfriendIntervalMinutes($unfriendIntervalMinutes)
    {
        $this->unfriendIntervalMinutes = $unfriendIntervalMinutes;
    }

    /**
     * @return int
     */
    public function getUnfriendAmountMax()
    {
        return $this->unfriendAmountMax;
    }

    /**
     * @param int $unfriendAmountMax
     */
    public function setUnfriendAmountMax($unfriendAmountMax)
    {
        $this->unfriendAmountMax = $unfriendAmountMax;
    }

    /**
     * @return int
     */
    public function getFollowIntervalMinutes()
    {
        return $this->followIntervalMinutes;
    }

    /**
     * @param int $followIntervalMinutes
     */
    public function setFollowIntervalMinutes($followIntervalMinutes)
    {
        $this->followIntervalMinutes = $followIntervalMinutes;
    }

    /**
     * @return int
     */
    public function getFollowAmountMax()
    {
        return $this->followAmountMax;
    }

    /**
     * @param int $followAmountMax
     */
    public function setFollowAmountMax($followAmountMax)
    {
        $this->followAmountMax = $followAmountMax;
    }

}