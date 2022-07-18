<?php

namespace App\Interfaces\Repositories;

interface PaymentRepositoryInterface
{

    public function create(array $data);
    public function update();
}
