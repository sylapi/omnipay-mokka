<?php

namespace Omnipay\Mokka\Message;

use Exception;
use GuzzleHttp\Psr7;
use Omnipay\Mokka\Trait;

class VoidRequest extends \Omnipay\Common\Message\AbstractRequest
{
    use Trait\Request;

    const API_PATH = '/factoring/v1/pre_check/cancel';
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

            return new VoidResponse($this, $response);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    public function getData()
    {

        $data = [
            'order_id' => $this->getTransactionReference(),
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
