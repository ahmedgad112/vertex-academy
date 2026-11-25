<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Instructor = 'instructor';
    case Student = 'student';

    public function label(): string
    {
        return match ($this) {
            self::Admin => __('roles.admin'),
            self::Instructor => __('roles.instructor'),
            self::Student => __('roles.student'),
        };
    }

    public function portalRoute(): string
    {
        return match ($this) {
            self::Admin => 'admin.dashboard',
            self::Instructor => 'instructor.dashboard',
            self::Student => 'student.dashboard',
        };
    }
}
