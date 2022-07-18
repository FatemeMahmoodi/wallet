<?php

namespace App\Interfaces\Services;

interface PaymentGatewayInterface
{

    public function pay(array $data);

    public function setCallbackUrl();

    public function callback(array $data);

    public function verify(array $data);

}
