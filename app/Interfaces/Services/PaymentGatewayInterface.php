<?php

namespace App\Interfaces\Services;

interface PaymentGatewayInterface
{

    public function pay();

    public function verify();

}
