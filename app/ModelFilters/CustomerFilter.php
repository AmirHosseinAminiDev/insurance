<?php

namespace App\ModelFilters;

use Morilog\Jalali\Jalalian;

class CustomerFilter extends BaseFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function search($search)
    {
        $this->where('first_name', 'LIKE','%'. $search.'%')
            ->orWhere('last_name', 'LIKE','%'. $search.'%')
            ->orWhere('national_code', 'LIKE','%'. $search.'%')
            ->orWhere('mobile', 'LIKE','%'. $search.'%');
    }
}
