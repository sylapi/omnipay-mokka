<?php


namespace Omnipay\Mokka\Message;

use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Mokka\Trait;

class PurchaseResponse extends \Omnipay\Common\Message\AbstractResponse implements RedirectResponseInterface
{
    use Trait\Response;

    public function isSuccessful()
    {
        return $this->isSuccessfulResponse();
    }

    public function isRedirect()
    {
        $redirectUrl = $this->data['iframe_url'] ?? null;
        return ($this->isSuccessful() && $redirectUrl);
    }

    public function getTransactionId()
    {
        return ($this->isSuccessful()) ? $this->data['transactionId'] : null;
    }

    public function getRedirectUrl()
    {
        return ($this->isRedirect()) ? $this->data['iframe_url'] : null;
    }

    public function getRedirectData()
    {
        return $this->data;
    }
}
