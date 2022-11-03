<?php

namespace Omnipay\Mokka\Message;

use Omnipay\Mokka\Trait;

class CompletePurchaseResponse extends \Omnipay\Common\Message\AbstractResponse
{   
    use Trait\Response;

    public function isSuccessful()
    {   
        return $this->isSuccessfulResponse();
    }

    public function getTransactionId()
    {
        return ($this->isSuccessful()) ? $this->data['transactionId'] : null;
    }
}
