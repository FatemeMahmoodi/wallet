<?php namespace App\Repositories;


use App\Models\Payment;
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
    public function list(array $input)
    {
        $paginator = $this->getPaginator(Payment::class, $income->filters()['filter'], [
            'user' => function ($q, $filter) {
                $q->where(Payment::fn('entity'), $filter['value'])
                    ->where(Payment::fn('entityType'), PaymentEntityTypeEnums::USER);
            }
        ]);
        $data['items'] = $paginator->items();
        $data['totalItems'] = $paginator->total();
        $data['itemsPerPage'] = $paginator->perPage();
        $data['currentPage'] = $paginator->currentPage();

        return $data;
        $select = [
            'sum(`cost`) as `holding`',
            'date(`updated_at`) as `date`',
        ];
        $report = Payment::query()
            ->selectRaw(implode(',', $select))
            ->where(Payment::fn('coffee'), COFFEE_ID)
            ->where(Payment::fn('status'), PaymentStatusEnums::SUCCESS)
            ->where(Payment::fn('method'), PaymentMethodEnums::METHODS[$income->filter('method')])
            ->whereNotIN(
                Payment::fn('entityType'),
                [PaymentEntityTypeEnums::RENEW, PaymentEntityTypeEnums::SMS_CREDIT]
            )
            ->groupBy(DB::raw('date(`updated_at`)'));

        if ($income->hasFilter('start')) {
            if ($income->hasFilter('end')) {
                $report->where(DB::raw('date(`updated_at`)'), '>=', $income->filter('start'))
                    ->where(DB::raw('date(`updated_at`)'), '<=', $income->filter('end'));
            } else {
                $report->where(DB::raw('date(`updated_at`)'), $income->filter('start'));
            }
        }

        return $report->get()->toArray();
    }


}
