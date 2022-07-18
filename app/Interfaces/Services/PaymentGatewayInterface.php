<?php

namespace App\Interfaces\Services;

interface PaymentGatewayInterface
{

    public function pay();

    public function setCallbackUrl();

    public function callback();

    public function verify();

}
