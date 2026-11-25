<?php

namespace Database\Seeders;

use App\Enums\CourseStatus;
use App\Enums\CourseType;
use App\Enums\UserRole;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructor = User::query()
            ->where('role', UserRole::Instructor)
            ->first()
            ?? User::factory()->instructor()->create([
                'email' => 'instructor@vertex-academy.com',
                'name' => 'Vertex Instructor',
            ]);

        $courses = [
            [
                'title' => 'Introduction to Laboratory Quality',
                'summary' => 'A free primer on quality systems for medical laboratories.',
                'type' => CourseType::Free,
                'price_cents' => 0,
                'duration_hours' => 6,
                'level' => 'Beginner',
            ],
            [
                'title' => 'Rapid Microbiology Diagnostics Workshop',
                'summary' => 'A focused short course on modern diagnostic workflows.',
                'type' => CourseType::Short,
                'price_cents' => 4900,
                'duration_hours' => 8,
                'level' => 'Intermediate',
            ],
            [
                'title' => 'Clinical & Diagnostic Microbiology Masterclass',
                'summary' => 'A complete paid pathway from fundamentals to advanced practice.',
                'type' => CourseType::Paid,
                'price_cents' => 19900,
                'duration_hours' => 36,
                'level' => 'Advanced',
            ],
        ];

        foreach ($courses as $course) {
            Course::query()->updateOrCreate(
                ['slug' => Str::slug($course['title'])],
                [
                    ...$course,
                    'instructor_id' => $instructor->id,
                    'description' => $course['summary'].' Built for Vertex Academy learners.',
                    'status' => CourseStatus::Published,
                    'currency' => 'USD',
                    'published_at' => now(),
                ],
            );
        }
    }
}
