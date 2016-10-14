<?php

namespace Twbot\Repository;


use Twbot\Entity\Proxy;

class ProxyRepository
{
    /**
     * @return array
     */
    public static function getProxiesArray()
    {
        return Yaml::parse(file_get_contents(PROXIES_DATA_FILE));
    }

    /**
     * @return Proxy[]
     */
    public static function getProxies()
    {
        $accessor = new PropertyAccessor(true);

        $proxiesArray = self::getProxiesArray();
        $proxies = [];

        foreach($proxiesArray as $proxyArray){
            $proxy = new Proxy();

            foreach($proxyArray as $proxyKey => $proxyValue) {
                $proxyKey = preg_replace("/[^A-Za-z0-9 ]/", '', $proxyKey);

                try {
                    $accessor->setValue($proxy, $proxyKey, $proxyValue);
                }
                catch(\Exception $ex){
                    var_dump($ex);
                    die;

                    //log error
                }
            }

            $proxies[] = $proxy;
        }

        return $proxies;
    }

    /**
     * @param string $id
     * @return Proxy|null
     */
    public static function getProxyById($id)
    {
        $proxies = self::getProxies();
        $foundProxy = null;

        foreach($proxies as $proxy){
            if($proxy->getId() == $id){
                $foundProxy = $proxy;

                break;
            }
        }

        return $foundProxy;
    }
}