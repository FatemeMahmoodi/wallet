<?php

namespace App\Services;

use App\Interfaces\Services\PaymentGatewayInterface;

class PaymentGatewayRegistry
{

    protected $gateways = [];

    /**
     * @param $name
     * @param PaymentGatewayInterface $instance
     * @return $this
     */
    function register($name, PaymentGatewayInterface $instance)
    {
        $this->gateways[$name] = $instance;
        return $this;
    }

    function get($name)
    {
        if (array_key_exists($name, $this->gateways)) {
            return $this->gateways[$name];
        } else {
            throw new \Exception(trans('payment.invalid_gateway'));
        }
    }

}
