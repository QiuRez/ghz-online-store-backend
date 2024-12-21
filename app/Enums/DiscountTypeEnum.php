<?php

namespace App\Enums;

enum DiscountTypeEnum: string
{
    case PERCENT = 'percent';
    case CURRENCY = 'currency';

    public static function toArray(): array
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->name] = $case->value;
        }
        return $array;
    }
}
