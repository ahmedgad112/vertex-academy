<?php

namespace App\Support;

use App\Models\Course;
use App\Models\Enrollment;

class CoursePresenter
{
    /**
     * @return array<string, mixed>
     */
    public static function toArray(Course $course, ?Enrollment $enrollment = null): array
    {
        return [
            'id' => $course->id,
            'title' => $course->title,
            'slug' => $course->slug,
            'summary' => $course->summary,
            'description' => $course->description,
            'type' => $course->type->value,
            'type_label' => $course->type->label(),
            'status' => $course->status->value,
            'status_label' => $course->status->label(),
            'price_cents' => $course->price_cents,
            'price_label' => $course->priceLabel(),
            'currency' => $course->currency,
            'duration_hours' => $course->duration_hours,
            'level' => $course->level,
            'requires_payment' => $course->requiresPayment(),
            'instructor' => $course->relationLoaded('instructor') && $course->instructor
                ? [
                    'id' => $course->instructor->id,
                    'name' => $course->instructor->name,
                ]
                : null,
            'students_count' => $course->enrollments_count
                ?? ($course->relationLoaded('enrollments') ? $course->enrollments->count() : null),
            'enrollment' => $enrollment ? [
                'id' => $enrollment->id,
                'status' => $enrollment->status->value,
                'status_label' => $enrollment->status->label(),
                'unlocked' => $enrollment->isUnlocked(),
                'progress_percent' => $enrollment->progress_percent,
                'paid_at' => $enrollment->paid_at?->toDateTimeString(),
            ] : null,
        ];
    }
}
