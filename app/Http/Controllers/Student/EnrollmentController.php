<?php

namespace App\Http\Controllers\Student;

use App\Actions\Courses\EnrollStudentInCourse;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Support\CoursePresenter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EnrollmentController extends Controller
{
    public function store(Request $request, Course $course, EnrollStudentInCourse $enroll): RedirectResponse
    {
        abort_unless($course->status->value === 'published', 404);

        $enrollment = $enroll->handle($request->user(), $course, confirmPayment: false);

        if ($enrollment->isUnlocked()) {
            return redirect()
                ->route('student.library')
                ->with('success', 'Course added to your library.');
        }

        return redirect()
            ->route('student.courses.checkout', $course)
            ->with('success', 'Complete payment to unlock this course.');
    }

    public function checkout(Request $request, Course $course): Response
    {
        abort_unless($course->status->value === 'published', 404);
        abort_if($course->isFree(), 404);

        $enrollment = $request->user()
            ->enrollments()
            ->where('course_id', $course->id)
            ->first();

        return Inertia::render('Student/Catalog/Checkout', [
            'course' => CoursePresenter::toArray($course->load('instructor'), $enrollment),
        ]);
    }

    public function pay(Request $request, Course $course, EnrollStudentInCourse $enroll): RedirectResponse
    {
        abort_unless($course->status->value === 'published', 404);
        abort_if($course->isFree(), 404);

        $enroll->handle($request->user(), $course, confirmPayment: true);

        return redirect()
            ->route('student.library')
            ->with('success', 'Payment successful. Course unlocked in your library.');
    }
}
