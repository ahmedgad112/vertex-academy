<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CourseType;
use App\Enums\EnrollmentStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Support\CoursePresenter;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        $recentCourses = Course::query()
            ->with('instructor')
            ->withCount('enrollments')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn (Course $course) => CoursePresenter::toArray($course));

        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'students' => User::query()->where('role', UserRole::Student)->count(),
                'instructors' => User::query()->where('role', UserRole::Instructor)->count(),
                'admins' => User::query()->where('role', UserRole::Admin)->count(),
                'total_users' => User::query()->count(),
                'courses' => Course::query()->count(),
                'published_courses' => Course::query()->where('status', 'published')->count(),
                'free_courses' => Course::query()->where('type', CourseType::Free)->count(),
                'short_courses' => Course::query()->where('type', CourseType::Short)->count(),
                'paid_courses' => Course::query()->where('type', CourseType::Paid)->count(),
                'active_enrollments' => Enrollment::query()
                    ->where('status', EnrollmentStatus::Active)
                    ->count(),
                'revenue_cents' => (int) Enrollment::query()
                    ->whereNotNull('paid_at')
                    ->sum('amount_paid_cents'),
            ],
            'recentCourses' => $recentCourses,
        ]);
    }
}
