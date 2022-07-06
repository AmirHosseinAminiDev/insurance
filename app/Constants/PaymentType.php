<?php

namespace App\Constants;

final class PaymentType extends Enum
{

    const BANKTRANSFER = 'کارت به کارت';
    const ONLINE = 'آنلاین';
    const CASH = 'نقدی';

    public static function payTypeList(): array
    {
        return [
            self::BANKTRANSFER => 'کارت به کارت',
            self::ONLINE => 'آنلاین',
            self::CASH => 'نقدی',
        ];
    }
}
