<?php

namespace App\Http\Controllers\Student;

use App\Enums\CourseType;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Support\CoursePresenter;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CourseCatalogController extends Controller
{
    public function index(Request $request): Response
    {
        $type = $request->string('type')->toString();

        $enrollments = Enrollment::query()
            ->where('user_id', $request->user()->id)
            ->get()
            ->keyBy('course_id');

        $courses = Course::query()
            ->published()
            ->with('instructor')
            ->when(
                $type !== '' && CourseType::tryFrom($type),
                fn ($query) => $query->where('type', $type),
            )
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString()
            ->through(function (Course $course) use ($enrollments) {
                return CoursePresenter::toArray($course, $enrollments->get($course->id));
            });

        return Inertia::render('Student/Catalog/Index', [
            'courses' => $courses,
            'filters' => ['type' => $type !== '' ? $type : null],
            'types' => collect(CourseType::cases())->map(fn (CourseType $item) => [
                'value' => $item->value,
                'label' => $item->label(),
            ]),
        ]);
    }

    public function show(Request $request, Course $course): Response
    {
        abort_unless($course->status->value === 'published', 404);

        $enrollment = Enrollment::query()
            ->where('user_id', $request->user()->id)
            ->where('course_id', $course->id)
            ->first();

        return Inertia::render('Student/Catalog/Show', [
            'course' => CoursePresenter::toArray($course->load('instructor'), $enrollment),
        ]);
    }
}
