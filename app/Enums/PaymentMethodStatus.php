<?php

namespace App\Enums;

class PaymentMethodStatus
{
    const DEPOSIT = 1;
    const WITHDRAWAL = 2;
    const ALL = [
        self::DEPOSIT,
        self::WITHDRAWAL
    ];

}
