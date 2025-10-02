<?php

namespace App\Http\Enums;

enum EducationLevel: string
{
    use Enumable;
    case HIGH_SCHOOL = 'high_school';
    case DIPLOMA = 'diploma';
    case BACHELOR = 'bachelor';
    case MASTER = 'master';
    case PHD = 'phd';

    public function t()
    {
        return match ($this) {
            self::HIGH_SCHOOL => __('dashboard.high_school'),
            self::DIPLOMA => __('dashboard.diploma'),
            self::BACHELOR => __('dashboard.bachelor'),
            self::MASTER => __('dashboard.master'),
            self::PHD => __('dashboard.phd'),
        };
    }
}
