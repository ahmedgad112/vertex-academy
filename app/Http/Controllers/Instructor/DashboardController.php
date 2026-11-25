<?php

namespace App\Http\Controllers\Instructor;

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
        $instructorId = $request->user()->id;

        $courseIds = Course::query()
            ->where('instructor_id', $instructorId)
            ->pluck('id');

        $courses = Course::query()
            ->where('instructor_id', $instructorId)
            ->withCount('enrollments')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn (Course $course) => CoursePresenter::toArray($course));

        return Inertia::render('Instructor/Dashboard', [
            'instructor' => [
                'name' => $request->user()->name,
                'email' => $request->user()->email,
            ],
            'stats' => [
                'courses' => $courseIds->count(),
                'published' => Course::query()
                    ->where('instructor_id', $instructorId)
                    ->where('status', 'published')
                    ->count(),
                'students' => Enrollment::query()
                    ->whereIn('course_id', $courseIds)
                    ->unlocked()
                    ->distinct()
                    ->count('user_id'),
            ],
            'courses' => $courses,
        ]);
    }
}
