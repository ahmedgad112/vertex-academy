<?php

namespace App\Actions\Courses;

use App\Enums\CourseStatus;
use App\Enums\EnrollmentStatus;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class EnrollStudentInCourse
{
    public function handle(User $student, Course $course, bool $confirmPayment = false): Enrollment
    {
        if ($course->status !== CourseStatus::Published) {
            throw ValidationException::withMessages([
                'course' => 'This course is not available for enrollment.',
            ]);
        }

        return DB::transaction(function () use ($student, $course, $confirmPayment) {
            $enrollment = Enrollment::query()->firstOrNew([
                'user_id' => $student->id,
                'course_id' => $course->id,
            ]);

            if ($enrollment->exists && $enrollment->isUnlocked()) {
                return $enrollment;
            }

            if ($course->isFree()) {
                $enrollment->fill([
                    'status' => EnrollmentStatus::Active,
                    'amount_paid_cents' => 0,
                    'currency' => $course->currency,
                    'payment_reference' => null,
                    'paid_at' => now(),
                    'unlocked_at' => now(),
                ])->save();

                return $enrollment->fresh(['course']);
            }

            if (! $confirmPayment) {
                $enrollment->fill([
                    'status' => EnrollmentStatus::PendingPayment,
                    'amount_paid_cents' => 0,
                    'currency' => $course->currency,
                ])->save();

                return $enrollment->fresh(['course']);
            }

            $enrollment->fill([
                'status' => EnrollmentStatus::Active,
                'amount_paid_cents' => $course->price_cents,
                'currency' => $course->currency,
                'payment_reference' => 'PAY-'.Str::upper(Str::random(10)),
                'paid_at' => now(),
                'unlocked_at' => now(),
            ])->save();

            return $enrollment->fresh(['course']);
        });
    }
}
