<?php

namespace App\Enums;

enum EnrollmentStatus: string
{
    case PendingPayment = 'pending_payment';
    case Active = 'active';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::PendingPayment => 'Pending payment',
            self::Active => 'Active',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
        };
    }

    public function unlocksAccess(): bool
    {
        return $this === self::Active || $this === self::Completed;
    }
}
