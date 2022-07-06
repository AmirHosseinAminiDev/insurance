<?php

namespace App\Constants;

final class SaleType extends Enum
{

    const CASH = 'cash';
    const INSTALLMENT = 'installment';

    public static function statusList(): array
    {
        return [
            self::CASH => 'نقدی',
            self::INSTALLMENT => 'قسطی',
        ];
    }


}
