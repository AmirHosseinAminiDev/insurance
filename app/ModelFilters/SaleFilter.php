<?php

namespace App\ModelFilters;

use App\Constants\SaleType;
use EloquentFilter\ModelFilter;

class SaleFilter extends BaseFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function insuranceType($insurance_type): SaleFilter
    {
        if ($insurance_type != 'all') {
            return $this->related('insuranceType', 'name', $insurance_type);
        }
        return $this;
    }

    public function customer($customer): SaleFilter
    {
        if ($customer != 'all') {
            return $this->related('customer', 'id', $customer);
        }
        return $this;
    }
}
