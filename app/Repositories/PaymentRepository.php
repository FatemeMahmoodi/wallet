<?php namespace App\Repositories;

use App\Entities\Coffee\Coffee;
use App\Entities\Payment\PaymentTransaction;
use App\Entities\User\Credit;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Infrastructure\Enumerations\Payment\PaymentMethodEnums;
use Infrastructure\Enumerations\Payment\PaymentStatusEnums;
use Infrastructure\Enumerations\Payment\PaymentEntityTypeEnums;
use App\Interfaces\Repositories\PaymentRepositoryInterface;


class PaymentRepository implements PaymentRepositoryInterface
{

    public function find(array $data)
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
    }

    public function create(array $data)
    {
        $entity = new Payment();
        $entity->fSet('coffee', COFFEE_ID);
        $entity->fSet('entity', $income->input('payment.entity'));
        $entity->fSet('entityType', PaymentEntityTypeEnums::TYPES[$income->input('payment.entityType')]);
        $entity->fSet('user', $income->input('payment.user'));
        $entity->fSet('method', PaymentMethodEnums::METHODS[$income->input('payment.method')]);
        $entity->fSet('cost', $income->input('payment.cost'));
        $entity->fSet('status', PaymentStatusEnums::SUCCESS);
        $entity->fSet('comment', $income->input('payment.comment'));
        $entity->fSet('createdBy', Auth::id());
        DB::transaction(function () use ($entity) {
            $entity->save();
            $credit = new Credit();
            $credit->fSets([
                'user' => $entity->fGet('user'),
                'payment' => $entity->fGet('id'),
                'cost' => $entity->fGet('cost'),
            ]);
            $credit->save();
            $credit->user->updateCredit();
            $payment = new Payment();
            $payment->fSet('coffee', COFFEE_ID);
            $payment->fSet('entity', $entity->fGet('entity'));
            $payment->fSet('entityType', $entity->fGet('entityType'));
            $payment->fSet('user', $entity->fGet('entity'));
            $payment->fSet('method', PaymentMethodEnums::SYSTEM);
            $payment->fSet('cost', -1 * $entity->fGet('cost'));
            $payment->fSet('status', PaymentStatusEnums::SUCCESS);
            $payment->fSet('comment', 'کیف پول شارژ شد');
            $payment->fSet('createdBy', 0);
            $payment->save();

        });


        return $entity->fGet('id');
    }

    public function update(array $data)
    {
        $entity = new Payment();
        $entity->fSet('coffee', COFFEE_ID);
        $entity->fSet('entity', $income->input('payment.entity'));
        $entity->fSet('entityType', PaymentEntityTypeEnums::TYPES[$income->input('payment.entityType')]);
        $entity->fSet('user', $income->input('payment.user'));
        $entity->fSet('method', PaymentMethodEnums::METHODS[$income->input('payment.method')]);
        $entity->fSet('cost', $income->input('payment.cost'));
        $entity->fSet('status', PaymentStatusEnums::SUCCESS);
        $entity->fSet('comment', $income->input('payment.comment'));
        $entity->fSet('createdBy', Auth::id());
        DB::transaction(function () use ($entity) {
            $entity->save();
            $credit = new Credit();
            $credit->fSets([
                'user' => $entity->fGet('user'),
                'payment' => $entity->fGet('id'),
                'cost' => $entity->fGet('cost'),
            ]);
            $credit->save();
            $credit->user->updateCredit();
            $payment = new Payment();
            $payment->fSet('coffee', COFFEE_ID);
            $payment->fSet('entity', $entity->fGet('entity'));
            $payment->fSet('entityType', $entity->fGet('entityType'));
            $payment->fSet('user', $entity->fGet('entity'));
            $payment->fSet('method', PaymentMethodEnums::SYSTEM);
            $payment->fSet('cost', -1 * $entity->fGet('cost'));
            $payment->fSet('status', PaymentStatusEnums::SUCCESS);
            $payment->fSet('comment', 'کیف پول شارژ شد');
            $payment->fSet('createdBy', 0);
            $payment->save();

        });


        return $entity->fGet('id');
    }

    public function list(array $input)
    {
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
