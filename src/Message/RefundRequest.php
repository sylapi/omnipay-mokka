<?php

namespace Omnipay\Mokka\Message;

use Exception;
use Omnipay\Mokka\Trait;
use GuzzleHttp\Psr7;

class RefundRequest extends \Omnipay\Common\Message\AbstractRequest
{
    const API_PATH = '/factoring/v1/return';

    use Trait\Request;

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

            return new RefundResponse($this, $response);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }

    public function getData()
    {
        $data = [
            'order_id' => $this->getTransactionReference(),
            'amount' => $this->getAmount(),
        ];

        return $data;
    }
}
