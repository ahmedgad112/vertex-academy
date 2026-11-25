<?php

namespace App\Enums;

enum Permission: string
{
    case AccessAdminPortal = 'access_admin_portal';
    case AccessInstructorPortal = 'access_instructor_portal';
    case AccessStudentPortal = 'access_student_portal';

    case ViewUsers = 'view_users';
    case CreateUsers = 'create_users';
    case UpdateUsers = 'update_users';
    case DeleteUsers = 'delete_users';

    case ManagePrograms = 'manage_programs';
    case ManageCourses = 'manage_courses';
    case ManageEnrollments = 'manage_enrollments';
    case ManageNews = 'manage_news';
    case ManageSchools = 'manage_schools';
    case ViewReports = 'view_reports';

    case ViewAssignedPrograms = 'view_assigned_programs';
    case ManageOwnCourses = 'manage_own_courses';
    case ManageOwnSessions = 'manage_own_sessions';
    case ViewAssignedStudents = 'view_assigned_students';

    case ViewOwnEnrollments = 'view_own_enrollments';
    case EnrollInPrograms = 'enroll_in_programs';
    case AccessLibrary = 'access_library';
    case UpdateOwnProfile = 'update_own_profile';

    public function label(): string
    {
        return match ($this) {
            self::AccessAdminPortal => 'Access admin portal',
            self::AccessInstructorPortal => 'Access instructor portal',
            self::AccessStudentPortal => 'Access student portal',
            self::ViewUsers => 'View users',
            self::CreateUsers => 'Create users',
            self::UpdateUsers => 'Update users',
            self::DeleteUsers => 'Delete users',
            self::ManagePrograms => 'Manage programs',
            self::ManageCourses => 'Manage all courses',
            self::ManageEnrollments => 'Manage enrollments',
            self::ManageNews => 'Manage news',
            self::ManageSchools => 'Manage schools',
            self::ViewReports => 'View reports',
            self::ViewAssignedPrograms => 'View assigned programs',
            self::ManageOwnCourses => 'Manage own courses',
            self::ManageOwnSessions => 'Manage own sessions',
            self::ViewAssignedStudents => 'View assigned students',
            self::ViewOwnEnrollments => 'View own enrollments',
            self::EnrollInPrograms => 'Enroll in courses',
            self::AccessLibrary => 'Access course library',
            self::UpdateOwnProfile => 'Update own profile',
        };
    }

    public function group(): string
    {
        return match ($this) {
            self::AccessAdminPortal,
            self::AccessInstructorPortal,
            self::AccessStudentPortal => 'Portals',
            self::ViewUsers,
            self::CreateUsers,
            self::UpdateUsers,
            self::DeleteUsers => 'Users',
            self::ManagePrograms,
            self::ManageCourses,
            self::ManageEnrollments,
            self::ManageNews,
            self::ManageSchools,
            self::ViewReports => 'Academy',
            self::ViewAssignedPrograms,
            self::ManageOwnCourses,
            self::ManageOwnSessions,
            self::ViewAssignedStudents => 'Instructor',
            self::ViewOwnEnrollments,
            self::EnrollInPrograms,
            self::AccessLibrary,
            self::UpdateOwnProfile => 'Student',
        };
    }
}
