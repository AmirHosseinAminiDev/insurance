<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;
use Morilog\Jalali\Jalalian;

class BaseFilter extends ModelFilter
{


    public function startDate($date)
    {
        $date = Jalalian::fromFormat('Y/m/d', $date)->toCarbon();
        $this->whereDate('created_at', '>=', $date->format('Y-m-d'));
    }

    public function endDate($date)
    {
        $date = Jalalian::fromFormat('Y/m/d', $date)->toCarbon();
        $this->whereDate('created_at', '<=', $date->format('Y-m-d'));
    }
}
