<?php

namespace Omnipay\Mokka\Trait;

trait Request {

    public function getPosId()
    {
        return $this->getParameter('posId');
    }

    public function setPosId($value)
    {
        return $this->setParameter('posId', $value);
    }

    public function getShopId()
    {
        return $this->getParameter('shopId');
    }

    public function setShopId($value)
    {
        return $this->setParameter('shopId', $value);
    }


    public function getClientSecret()
    {
        return $this->getParameter('clientSecret');
    }

    public function setClientSecret($clientSecret)
    {
        return $this->setParameter('clientSecret', $clientSecret);
    }

    public function getApiUrl()
    {        
        if ($this->getTestMode()) {
            return 'https://stage-backend.mokka.ro';
        } else {
            return 'https://b.mokka.ro';
        }
    }

    public function setApiUrl($apiUrl)
    {
        $this->setParameter('apiUrl', $apiUrl);
    }


    public function getHeaders(array $append = [])
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        return array_merge($headers,$append);
    }

    public function getAuthApiUrl(string $path, array $data) 
    {
        return $this->getApiUrl() . $path. '?store_id=' . $this->getShopId() . '&signature=' . $this->getSignature($data);
    }


    public function getSignature(array $data)
    {
        $data = json_encode($data);
        return sha1($data.$this->getClientSecret());
    }

    
}