<?php

namespace App\Enums;

enum Country: string
{
    case BRAZIL = 'Brazil';
    case CANADA = 'Canada';
    case AUSTRALIA = 'Australia';

    public static function isValid(string $value): bool {
        return in_array($value, array_column(Country::cases(), 'value'));
    }
}
