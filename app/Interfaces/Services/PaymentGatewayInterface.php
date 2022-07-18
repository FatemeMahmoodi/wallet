<?php

namespace App\Interfaces\Services;

interface PaymentGatewayInterface
{

    public function pay();

    public function callback();

    public function verify();

}
