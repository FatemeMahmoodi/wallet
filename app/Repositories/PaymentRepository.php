<?php namespace App\Repositories;


use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\Repositories\PaymentRepositoryInterface;


class PaymentRepository implements PaymentRepositoryInterface
{
    /**
     * @param Payment $payment
     * @return Payment
     */
    public function find(Payment $payment): Payment
    {
        return $payment;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return Payment::create($data);
    }

    /**
     * @param Payment $payment
     * @param $status
     * @return bool
     */
    public function updatePaymentStatus(Payment $payment, $status)
    {
        return $payment->update(['status' => $status]);
    }

    /**
     * @param array $input
     * @return array
     */
    public function list(Request $request)
    {
        return Payment::currentUser()
            ->paginate($request->input('per_page', 10));
    }


}
