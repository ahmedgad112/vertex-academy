<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Enums\UserRole;
use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission(Permission::ViewUsers);
    }

    public function view(User $user, User $model): bool
    {
        return $user->hasPermission(Permission::ViewUsers);
    }

    public function create(User $user): bool
    {
        return $user->hasPermission(Permission::CreateUsers);
    }

    public function update(User $user, User $model): bool
    {
        return $user->hasPermission(Permission::UpdateUsers);
    }

    public function delete(User $user, User $model): bool
    {
        if (! $user->hasPermission(Permission::DeleteUsers)) {
            return false;
        }

        if ($user->is($model)) {
            return false;
        }

        if ($model->role === UserRole::Admin && $this->activeAdminCount() <= 1) {
            return false;
        }

        return true;
    }

    protected function activeAdminCount(): int
    {
        return User::query()
            ->where('role', UserRole::Admin)
            ->where('is_active', true)
            ->count();
    }
}
