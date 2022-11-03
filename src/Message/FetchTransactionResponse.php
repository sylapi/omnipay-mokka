<?php

namespace Omnipay\Mokka\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Mokka\Trait;

class FetchTransactionResponse extends \Omnipay\Common\Message\AbstractResponse
{
    use Trait\Response;

    public function isSuccessful()
    {   
        return $this->isSuccessfulResponse();
    }

    public function getTransactionId()
    {
        $data = $this->getData();
        if (isset($data['current_order']['order_id']) && !empty($data['current_order']['order_id'])) {
            return (string) $data['current_order']['order_id'];
        } else {
            throw new InvalidRequestException("Mokka data is missing");
        }
    }

    public function getStatus()
    {
        $data = $this->getData();
        if (isset($data['current_order']['status']) && !empty($data['current_order']['status'])) {
            return (string) $data['current_order']['status'];
        } else {
            throw new InvalidRequestException("Mokka data is missing");
        }
    }
}
