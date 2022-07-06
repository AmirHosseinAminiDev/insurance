<?php

namespace App\Constants;

final class GatewayStatus extends Enum
{

    const SUCCESS = 'success';
    const INIT = 'init';
    const FAILED = 'failed';

    public static function statusList()
    {
        return [
            self::SUCCESS => 'موفق',
            self::INIT => 'نامشخص',
            self::FAILED => 'ناموفق',
        ];
    }
}
