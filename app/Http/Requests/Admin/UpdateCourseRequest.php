<?php

namespace App\Http\Requests\Admin;

use App\Enums\CourseStatus;
use App\Enums\CourseType;
use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Course $course */
        $course = $this->route('course');

        return $this->user()?->can('update', $course) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'type' => ['required', Rule::enum(CourseType::class)],
            'status' => ['required', Rule::enum(CourseStatus::class)],
            'price' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'duration_hours' => ['nullable', 'integer', 'min:1', 'max:1000'],
            'level' => ['nullable', 'string', 'max:50'],
            'instructor_id' => ['nullable', 'exists:users,id'],
        ];
    }
}
