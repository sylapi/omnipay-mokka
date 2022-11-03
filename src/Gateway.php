<?php

namespace Omnipay\Mokka;

use Omnipay\Mokka\Trait;
use Omnipay\Common\AbstractGateway;
use Omnipay\Mokka\Message\VoidRequest;
use Omnipay\Mokka\Message\PurchaseRequest;
use Omnipay\Mokka\Message\CompletePurchaseRequest;
use Omnipay\Mokka\Message\FetchTransactionRequest;
use Omnipay\Mokka\Message\RefundRequest;

class Gateway extends AbstractGateway
{

    use Trait\Request;

    public function getName()
    {
        return 'Mokka';
    }

    public function getDefaultParameters()
    {
        return [
            'posId'        => '',
            'clientSecret' => '',
            'testMode'     => true
        ];
    }

    public function initialize(array $options = [])
    {
        parent::initialize($options);
        $this->setApiUrl($this->getApiUrl());
        return $this;
    }

    public function purchase(array $options = array())
    {
        return parent::createRequest(PurchaseRequest::class, $options);
    }

    public function completePurchase(array $options = array())
    {
        return parent::createRequest(CompletePurchaseRequest::class, $options);
    }

    public function fetchTransaction(array $options = [])
    {
        return parent::createRequest(FetchTransactionRequest::class, $options);
    }

    public function refund(array $options = array())
    {
        return parent::createRequest(RefundRequest::class, $options);
    }

    public function void(array $options = array())
    {
        return parent::createRequest(VoidRequest::class, $options);
    }    
}
