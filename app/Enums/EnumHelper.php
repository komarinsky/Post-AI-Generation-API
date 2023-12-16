<?php

namespace App\Enums;

trait EnumHelper
{
    public static function valuesArray(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function combinedKeyValuesArray(): array
    {
        $values = self::valuesArray();

        return array_combine($values, $values);
    }
}
