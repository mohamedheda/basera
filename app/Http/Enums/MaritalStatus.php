<?php

namespace App\Http\Enums;

enum MaritalStatus: string
{
    use Enumable;
    case SINGLE = 'single';
    case MARRIED = 'married';
    case DIVORCED = 'divorced';
    case WIDOWED = 'widowed';

    public function t()
    {
        return match ($this) {
            self::SINGLE => __('dashboard.single'),
            self::MARRIED => __('dashboard.married'),
            self::DIVORCED => __('dashboard.divorced'),
            self::WIDOWED => __('dashboard.widowed'),
        };
    }
}
