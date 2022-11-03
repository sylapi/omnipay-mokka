<?php

namespace Omnipay\Mokka\Message;

use Exception;
use GuzzleHttp\Psr7;
use Omnipay\Mokka\Trait;

class PurchaseRequest extends \Omnipay\Common\Message\AbstractRequest
{
    use Trait\Request;

    const API_PATH = '/factoring/v1/pre_check/auth';

    public function sendData($data)
    {
        $apiUrl = $this->getAuthApiUrl(self::API_PATH, $data);
        $headers = $this->getHeaders([
            'Content-Type' => 'application/json',
        ]);

        try {
            $body = Psr7\Utils::streamFor(json_encode($data));
            $result = $this->httpClient->request(
                'POST', 
                $apiUrl, 
                $headers, 
                $body
            );

            $response = json_decode($result->getBody(), true);
            $response['transactionId'] = $this->getTransactionReference();
            $this->response = $response;

            return new PurchaseResponse($this, $response);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    public function getData()
    {

        $data = [
            'callback_url' => $this->getNotifyUrl(),
            'redirect_url' => $this->getReturnUrl(),
            'primary_phone' => $this->getPhone(),
            'primary_email' => $this->getEmail(),
            'current_order' => [
                'order_id' => $this->getTransactionReference(),
                'amount' => $this->getAmount()
            ],
        ];

        return $data;
    }


    public function getEmail()
    {
        return $this->getParameter('email');
    }

    public function setEmail($value)
    {
        return $this->setParameter('email', $value);
    }

    public function getPhone()
    {
        return $this->getParameter('phone');
    }

    public function setPhone($value)
    {
        return $this->setParameter('phone', $value);
    }
}
