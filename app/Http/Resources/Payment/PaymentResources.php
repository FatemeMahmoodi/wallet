<?php

namespace App\Http\Resources\Payment;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResources extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "amount" => $this->amount,
            "status" => $this->status,
            "paymentMethod" => $this->payment_method,
            "createdAt" => $this->created_at,
            'verifyData' => $this->verfiy_data,
            "paidData" => $this->paid_data
        ];
    }

}
