<?php

namespace App\Enums;

enum TransactionStatus: string
{
    case pending = 'pending';
    case success = 'success';
    case fail = 'fail';

    public static function values(): array
    {
        return array_map(fn(TransactionStatus $s) => $s->value, self::cases());
    }
}
