<?php

namespace App\Models;

use App\Enums\Permission;
use App\Enums\UserRole;
use App\Support\RolePermissions;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'is_active'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'is_active' => 'boolean',
        ];
    }

    /**
     * @return HasOne<StudentProfile, $this>
     */
    public function studentProfile(): HasOne
    {
        return $this->hasOne(StudentProfile::class);
    }

    /**
     * @return HasMany<Course, $this>
     */
    public function instructedCourses(): HasMany
    {
        return $this->hasMany(Course::class, 'instructor_id');
    }

    /**
     * @return HasMany<Enrollment, $this>
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    public function isInstructor(): bool
    {
        return $this->role === UserRole::Instructor;
    }

    public function isStudent(): bool
    {
        return $this->role === UserRole::Student;
    }

    public function hasRole(UserRole|string ...$roles): bool
    {
        $values = collect($roles)->map(
            fn (UserRole|string $role) => $role instanceof UserRole ? $role : UserRole::from($role),
        );

        return $values->contains($this->role);
    }

    public function hasPermission(Permission|string $permission): bool
    {
        if (! $this->is_active) {
            return false;
        }

        $permission = $permission instanceof Permission
            ? $permission
            : Permission::from($permission);

        return RolePermissions::roleHas($this->role, $permission);
    }

    /**
     * @return list<string>
     */
    public function permissionValues(): array
    {
        if (! $this->is_active) {
            return [];
        }

        return RolePermissions::valuesFor($this->role);
    }

    public function portalRouteName(): string
    {
        return $this->role->portalRoute();
    }
}
