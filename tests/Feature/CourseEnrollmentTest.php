<?php

namespace Tests\Feature;

use App\Enums\EnrollmentStatus;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseEnrollmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_enroll_in_free_course_and_unlock_library(): void
    {
        $student = User::factory()->student()->create();
        $course = Course::factory()->free()->create();

        $this->actingAs($student)
            ->post(route('student.courses.enroll', $course->slug))
            ->assertRedirect(route('student.library'));

        $this->assertDatabaseHas('enrollments', [
            'user_id' => $student->id,
            'course_id' => $course->id,
            'status' => EnrollmentStatus::Active->value,
        ]);
    }

    public function test_paid_course_requires_payment_before_library_unlock(): void
    {
        $student = User::factory()->student()->create();
        $course = Course::factory()->paid()->create();

        $this->actingAs($student)
            ->post(route('student.courses.enroll', $course->slug))
            ->assertRedirect(route('student.courses.checkout', $course->slug));

        $this->assertDatabaseHas('enrollments', [
            'user_id' => $student->id,
            'course_id' => $course->id,
            'status' => EnrollmentStatus::PendingPayment->value,
        ]);

        $this->actingAs($student)
            ->post(route('student.courses.pay', $course->slug))
            ->assertRedirect(route('student.library'));

        $this->assertDatabaseHas('enrollments', [
            'user_id' => $student->id,
            'course_id' => $course->id,
            'status' => EnrollmentStatus::Active->value,
        ]);
    }

    public function test_admin_can_create_course_with_type(): void
    {
        $admin = User::factory()->admin()->create();
        $instructor = User::factory()->instructor()->create();

        $this->actingAs($admin)
            ->post(route('admin.courses.store'), [
                'title' => 'Short Patient Safety Course',
                'summary' => 'Focused short course',
                'description' => 'Details',
                'type' => 'short',
                'status' => 'published',
                'price' => 39,
                'currency' => 'USD',
                'duration_hours' => 6,
                'level' => 'Beginner',
                'instructor_id' => $instructor->id,
            ])
            ->assertRedirect(route('admin.courses.index'));

        $this->assertDatabaseHas('courses', [
            'title' => 'Short Patient Safety Course',
            'type' => 'short',
            'price_cents' => 3900,
        ]);
    }
}
