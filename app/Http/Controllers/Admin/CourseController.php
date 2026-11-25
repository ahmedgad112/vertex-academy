<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CourseStatus;
use App\Enums\CourseType;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCourseRequest;
use App\Http\Requests\Admin\UpdateCourseRequest;
use App\Models\Course;
use App\Models\User;
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

        $type = $request->string('type')->toString();

        $courses = Course::query()
            ->with('instructor')
            ->withCount('enrollments')
            ->when(
                $type !== '' && CourseType::tryFrom($type),
                fn ($query) => $query->where('type', $type),
            )
            ->latest()
            ->paginate(12)
            ->withQueryString()
            ->through(fn (Course $course) => CoursePresenter::toArray($course));

        return Inertia::render('Admin/Courses/Index', [
            'courses' => $courses,
            'filters' => ['type' => $type !== '' ? $type : null],
            'types' => $this->typeOptions(),
        ]);
    }

    public function create(): Response
    {
        Gate::authorize('create', Course::class);

        return Inertia::render('Admin/Courses/Form', [
            'course' => null,
            'types' => $this->typeOptions(),
            'statuses' => $this->statusOptions(),
            'instructors' => User::query()
                ->whereIn('role', [UserRole::Instructor, UserRole::Admin])
                ->where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'name', 'role']),
        ]);
    }

    public function store(StoreCourseRequest $request): RedirectResponse
    {
        $data = $this->payload($request->validated(), $request->user()->id);

        Course::create($data);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function edit(Course $course): Response
    {
        Gate::authorize('update', $course);

        return Inertia::render('Admin/Courses/Form', [
            'course' => [
                ...CoursePresenter::toArray($course->load('instructor')),
                'price' => $course->price_cents / 100,
                'instructor_id' => $course->instructor_id,
            ],
            'types' => $this->typeOptions(),
            'statuses' => $this->statusOptions(),
            'instructors' => User::query()
                ->whereIn('role', [UserRole::Instructor, UserRole::Admin])
                ->where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'name', 'role']),
        ]);
    }

    public function update(UpdateCourseRequest $request, Course $course): RedirectResponse
    {
        $course->update($this->payload($request->validated(), $course->instructor_id));

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        Gate::authorize('delete', $course);

        $course->delete();

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    protected function payload(array $validated, int $fallbackInstructorId): array
    {
        $type = CourseType::from($validated['type']);
        $status = CourseStatus::from($validated['status']);
        $price = (float) ($validated['price'] ?? 0);

        return [
            'instructor_id' => $validated['instructor_id'] ?? $fallbackInstructorId,
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
        ];
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
