<?php

namespace App\Enums;

enum UserStatus: int
{
    case Inactive = 0;
    case Active = 1;
    case Deleted = 2;

    public static function label($value): string
    {
        return match ($value) {
            self::Inactive->value => 'Inactive',
            self::Active->value => 'Active',
            self::Deleted->value => 'Deleted'
        };
    }
}
