<?php

namespace App\Support;

use App\Enums\UserRole;
use App\Models\User;

class Portal
{
    public static function homeRoute(?User $user = null): string
    {
        if ($user === null) {
            return 'home';
        }

        return $user->portalRouteName();
    }

    /**
     * @return list<UserRole>
     */
    public static function managedByAdmin(): array
    {
        return [
            UserRole::Admin,
            UserRole::Instructor,
            UserRole::Student,
        ];
    }
}
