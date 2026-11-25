<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission(Permission::ManageCourses)
            || $user->hasPermission(Permission::ManageOwnCourses)
            || $user->hasPermission(Permission::EnrollInPrograms)
            || $user->hasPermission(Permission::AccessLibrary);
    }

    public function view(User $user, Course $course): bool
    {
        if ($user->hasPermission(Permission::ManageCourses)) {
            return true;
        }

        if ($user->hasPermission(Permission::ManageOwnCourses) && $course->instructor_id === $user->id) {
            return true;
        }

        return $course->status->value === 'published'
            && (
                $user->hasPermission(Permission::EnrollInPrograms)
                || $user->hasPermission(Permission::AccessLibrary)
            );
    }

    public function create(User $user): bool
    {
        return $user->hasPermission(Permission::ManageCourses)
            || $user->hasPermission(Permission::ManageOwnCourses);
    }

    public function update(User $user, Course $course): bool
    {
        if ($user->hasPermission(Permission::ManageCourses)) {
            return true;
        }

        return $user->hasPermission(Permission::ManageOwnCourses)
            && $course->instructor_id === $user->id;
    }

    public function delete(User $user, Course $course): bool
    {
        return $this->update($user, $course);
    }
}
