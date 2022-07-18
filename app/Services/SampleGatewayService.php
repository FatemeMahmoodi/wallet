<?php

namespace App\Services;

use App\Interfaces\Services\PaymentGatewayInterface;
use Illuminate\Support\Facades\Request;

class SampleGatewayService implements PaymentGatewayInterface
{
    private $client;
    private $callbackUrl;

    public function __construct()
    {
        // here connection to gateway
    }

    public function pay(array $data)
    {
        // request to payment gateway
    }

    public function setCallbackUrl()
    {
        $this->callbackUrl = Request::root() . config('paymentGateway.callbackUrl') . '/sample';
    }

    public function callback(array $data)
    {
        // callback from gateway
    }

    public function verify(array $data)
    {
        // verify a payment
    }

    private function curlPost(string $url, array $params)
    {
    }


}
