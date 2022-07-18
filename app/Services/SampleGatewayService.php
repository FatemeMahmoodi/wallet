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

    public function pay()
    {
        // request to payment gateway
    }

    public function setCallbackUrl()
    {
        $this->callbackUrl = Request::root() . config('paymentGateway.callbackUrl') . '/sample';
    }

    public function callback()
    {
        // callback from gateway
    }

    public function verify()
    {
        // verify a payment
    }

    private function curlPost(string $url, array $params)
    {
    }


}
