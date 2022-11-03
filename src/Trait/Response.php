<?php

namespace Omnipay\Mokka\Trait;

trait Response {

    private $message;
    private $code;

    public function isSuccessfulResponse()
    {
        $success = (isset($this->data['status']) && $this->data['status'] === 0); 

        if($success === false) {
            $this->setMessage($this->data['message'] ?? 'Something went wrong.');
            $this->setCode($this->data['status'] ?? null);
        }

        return $success;
    }
    
    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($value)
    {
        return $this->message = $value;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($value)
    {
        return $this->code = $value;
    }
    
}