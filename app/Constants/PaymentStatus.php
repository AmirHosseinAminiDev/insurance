<?php

namespace App\Constants;

final class PaymentStatus extends Enum
{

    const PAID = 'paid';
    const PENDING = 'pending';
    const UNPAID = 'unpaid';

    public static function statusList(): array
    {
        return [
            self::PAID => 'پرداخت شده',
            self::PENDING => 'درانتظار پرداخت',
            self::UNPAID => 'پرداخت نشده',
        ];
    }
}
