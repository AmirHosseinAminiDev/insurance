<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest;

class PersianInputsNormalization extends TransformsRequest
{
    protected function transform($key, $value)
    {
        // Check if value is empty then convert it to null object [ Do not use if PersianInputsNormalization middleware is executed ]
        if (is_null(self::convertEmptyStringToNull($value)))
            return null;

        $value = preg_replace('!\s+!', ' ', $value);    // Replace more than one whitespace with a single whitespace

        $value = self::standardizeNumbers($value); // Replace Persian and Arabic digits with English

        $value = self::standardizeCharacters($value); // Replace Arabic characters with Persian

        return $value;
    }


    private static function standardizeNumbers($value)
    {
        $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];   // Persian numbers array
        $arabicNumbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];    // Arabic numbers array
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];   // English numbers array
        $value = str_replace($persianNumbers, $englishNumbers, $value); // Replace Persian digits with English
        $value = str_replace($arabicNumbers, $englishNumbers, $value); // Replace Arabic digits with English
        return $value;
    }

    private static function standardizeCharacters($value)
    {
        $value = str_replace('ي', 'ی', $value); // Replace Arabic character with Persian
        $value = str_replace('ك', 'ک', $value); // Replace Arabic character with Persian
        return $value;
    }

    public static function convertEmptyStringToNull($value)
    {
        $value = trim($value);
        return is_string($value) && $value === '' ? null : $value;
    }
}
