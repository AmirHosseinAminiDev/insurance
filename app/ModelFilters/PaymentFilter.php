<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class PaymentFilter extends BaseFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [
    ];

    public function sortFilter($sortFilter): PaymentFilter
    {
        if (request('sortFilter') != 'all') {
            return $this->where('status', $sortFilter);
        }
        return $this;
    }

    public function statusPayment($status_payment)
    {
        if ($status_payment == 'today') {
            return $this->where('due_date', today());
        } else if ($status_payment == 'expire') {
            return $this->where('due_date', '<', now());
        }
        return $this;
    }
}
