<?php

if (!function_exists('generateRandomCode')) {
    function generateRandomCode($length = 7): string
    {
        $pool = '0123456789';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
}
