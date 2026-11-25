<?php

namespace App\Http\Controllers\Instructor;

use App\Enums\CourseStatus;
use App\Enums\CourseType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCourseRequest;
use App\Http\Requests\Admin\UpdateCourseRequest;
use App\Models\Course;
use App\Support\CoursePresenter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class CourseController extends Controller
{
    public function index(Request $request): Response
    {
        Gate::authorize('viewAny', Course::class);

        $courses = Course::query()
            ->where('instructor_id', $request->user()->id)
            ->withCount('enrollments')
            ->latest()
            ->paginate(12)
            ->withQueryString()
            ->through(fn (Course $course) => CoursePresenter::toArray($course));

        return Inertia::render('Instructor/Courses/Index', [
            'courses' => $courses,
            'types' => $this->typeOptions(),
        ]);
    }

    public function create(): Response
    {
        Gate::authorize('create', Course::class);

        return Inertia::render('Instructor/Courses/Form', [
            'course' => null,
            'types' => $this->typeOptions(),
            'statuses' => $this->statusOptions(),
        ]);
    }

    public function store(StoreCourseRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $type = CourseType::from($validated['type']);
        $status = CourseStatus::from($validated['status']);
        $price = (float) ($validated['price'] ?? 0);

        Course::create([
            'instructor_id' => $request->user()->id,
            'title' => $validated['title'],
            'summary' => $validated['summary'] ?? null,
            'description' => $validated['description'] ?? null,
            'type' => $type,
            'status' => $status,
            'price_cents' => $type === CourseType::Free ? 0 : (int) round($price * 100),
            'currency' => strtoupper($validated['currency']),
            'duration_hours' => $validated['duration_hours'] ?? null,
            'level' => $validated['level'] ?? null,
            'published_at' => $status === CourseStatus::Published ? now() : null,
        ]);

        return redirect()
            ->route('instructor.courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function edit(Course $course): Response
    {
        Gate::authorize('update', $course);

        return Inertia::render('Instructor/Courses/Form', [
            'course' => [
                ...CoursePresenter::toArray($course),
                'price' => $course->price_cents / 100,
            ],
            'types' => $this->typeOptions(),
            'statuses' => $this->statusOptions(),
        ]);
    }

    public function update(UpdateCourseRequest $request, Course $course): RedirectResponse
    {
        Gate::authorize('update', $course);

        $validated = $request->validated();
        $type = CourseType::from($validated['type']);
        $status = CourseStatus::from($validated['status']);
        $price = (float) ($validated['price'] ?? 0);

        $course->update([
            'title' => $validated['title'],
            'summary' => $validated['summary'] ?? null,
            'description' => $validated['description'] ?? null,
            'type' => $type,
            'status' => $status,
            'price_cents' => $type === CourseType::Free ? 0 : (int) round($price * 100),
            'currency' => strtoupper($validated['currency']),
            'duration_hours' => $validated['duration_hours'] ?? null,
            'level' => $validated['level'] ?? null,
            'published_at' => $status === CourseStatus::Published
                ? ($course->published_at ?? now())
                : null,
        ]);

        return redirect()
            ->route('instructor.courses.index')
            ->with('success', 'Course updated successfully.');
    }

    /**
     * @return list<array{value: string, label: string}>
     */
    protected function typeOptions(): array
    {
        return collect(CourseType::cases())->map(fn (CourseType $type) => [
            'value' => $type->value,
            'label' => $type->label(),
        ])->all();
    }

    /**
     * @return list<array{value: string, label: string}>
     */
    protected function statusOptions(): array
    {
        return collect(CourseStatus::cases())->map(fn (CourseStatus $status) => [
            'value' => $status->value,
            'label' => $status->label(),
        ])->all();
    }
}
