<?php

namespace App\Enums;

enum CourseType: string
{
    case Free = 'free';
    case Short = 'short';
    case Paid = 'paid';

    public function label(): string
    {
        return match ($this) {
            self::Free => __('course.type.free'),
            self::Short => __('course.type.short'),
            self::Paid => __('course.type.paid'),
        };
    }

    public function requiresPayment(): bool
    {
        return $this !== self::Free;
    }
}
