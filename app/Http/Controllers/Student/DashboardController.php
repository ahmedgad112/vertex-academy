<?php

namespace App\Http\Controllers\Student;

use App\Enums\EnrollmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Support\CoursePresenter;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $user = $request->user()->load('studentProfile');

        $libraryCount = Enrollment::query()
            ->where('user_id', $user->id)
            ->unlocked()
            ->count();

        $pendingCount = Enrollment::query()
            ->where('user_id', $user->id)
            ->where('status', EnrollmentStatus::PendingPayment)
            ->count();

        $recent = Enrollment::query()
            ->with('course.instructor')
            ->where('user_id', $user->id)
            ->unlocked()
            ->latest('unlocked_at')
            ->take(3)
            ->get()
            ->map(fn (Enrollment $enrollment) => CoursePresenter::toArray($enrollment->course, $enrollment));

        $featured = Course::query()
            ->published()
            ->with('instructor')
            ->latest('published_at')
            ->take(3)
            ->get()
            ->map(fn (Course $course) => CoursePresenter::toArray($course));

        return Inertia::render('Student/Dashboard', [
            'student' => [
                'name' => $user->name,
                'email' => $user->email,
                'profile' => $user->studentProfile,
            ],
            'stats' => [
                'library' => $libraryCount,
                'pending' => $pendingCount,
                'available' => Course::query()->published()->count(),
            ],
            'recent' => $recent,
            'featured' => $featured,
        ]);
    }
}
