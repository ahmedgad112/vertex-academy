<?php

namespace App\Support;

use App\Enums\Permission;
use App\Enums\UserRole;

class RolePermissions
{
    /**
     * @return list<Permission>
     */
    public static function for(UserRole $role): array
    {
        return match ($role) {
            UserRole::Admin => [
                Permission::AccessAdminPortal,
                Permission::ViewUsers,
                Permission::CreateUsers,
                Permission::UpdateUsers,
                Permission::DeleteUsers,
                Permission::ManagePrograms,
                Permission::ManageCourses,
                Permission::ManageEnrollments,
                Permission::ManageNews,
                Permission::ManageSchools,
                Permission::ViewReports,
                Permission::UpdateOwnProfile,
            ],
            UserRole::Instructor => [
                Permission::AccessInstructorPortal,
                Permission::ViewAssignedPrograms,
                Permission::ManageOwnCourses,
                Permission::ManageOwnSessions,
                Permission::ViewAssignedStudents,
                Permission::UpdateOwnProfile,
            ],
            UserRole::Student => [
                Permission::AccessStudentPortal,
                Permission::ViewOwnEnrollments,
                Permission::EnrollInPrograms,
                Permission::AccessLibrary,
                Permission::UpdateOwnProfile,
            ],
        };
    }

    /**
     * @return list<string>
     */
    public static function valuesFor(UserRole $role): array
    {
        return array_map(
            fn (Permission $permission) => $permission->value,
            self::for($role),
        );
    }

    public static function roleHas(UserRole $role, Permission $permission): bool
    {
        return in_array($permission, self::for($role), true);
    }

    /**
     * @return array<string, list<array{value: string, label: string, group: string}>>
     */
    public static function matrix(): array
    {
        $matrix = [];

        foreach (UserRole::cases() as $role) {
            $matrix[$role->value] = array_map(
                fn (Permission $permission) => [
                    'value' => $permission->value,
                    'label' => $permission->label(),
                    'group' => $permission->group(),
                ],
                self::for($role),
            );
        }

        return $matrix;
    }
}
