<?php

namespace Omnipay\Mokka\Message;

use Exception;
use GuzzleHttp\Psr7;
use Omnipay\Mokka\Trait;

class CompletePurchaseRequest extends \Omnipay\Common\Message\AbstractRequest
{
    use Trait\Request;

    const API_PATH = '/factoring/v1/pre_check/finish';
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

            return new FetchTransactionResponse($this, $response);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    public function getData()
    {

        $data = [
            'order_id' => $this->getTransactionReference(),
            'amount' => $this->getAmount()
        ];

        return $data;
    }

    public function getTransactionReference()
    {
        return $this->getParameter('transactionReference');
    }

    public function setTransactionReference($value)
    {
        return $this->setParameter('transactionReference', $value);
    }
}
