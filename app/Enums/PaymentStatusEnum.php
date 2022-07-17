<?php

namespace App\Enums;

class PaymentStatusEnum
{
    const WAITING = 1;
    const SUCCESS = 2;
    const FAIL = 3;

    const ALL = [
        self::SUCCESS,
        self::WAITING,
        self::FAIL
    ];
}
