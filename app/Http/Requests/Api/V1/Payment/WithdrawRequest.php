<?php

namespace App\Http\Requests\Api\V1\Payment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class WithdrawRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => [
                'required',
                'string',
                'numeric',
                'min:10000',
                function ($attribute, $value, $fail) {
                    if (Auth::user()->balance < $value) {
                        $fail(trans('payment.insufficient_funds'));
                    }
                },
            ]
        ];
    }
}
