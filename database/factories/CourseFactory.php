<?php

namespace Database\Factories;

use App\Enums\CourseStatus;
use App\Enums\CourseType;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'instructor_id' => User::factory()->instructor(),
            'title' => rtrim($title, '.'),
            'slug' => fake()->unique()->slug(),
            'summary' => fake()->sentence(12),
            'description' => fake()->paragraphs(3, true),
            'type' => CourseType::Paid,
            'status' => CourseStatus::Published,
            'price_cents' => 9900,
            'currency' => 'USD',
            'duration_hours' => fake()->numberBetween(4, 40),
            'level' => fake()->randomElement(['Beginner', 'Intermediate', 'Advanced']),
            'published_at' => now(),
        ];
    }

    public function free(): static
    {
        return $this->state(fn () => [
            'type' => CourseType::Free,
            'price_cents' => 0,
        ]);
    }

    public function short(): static
    {
        return $this->state(fn () => [
            'type' => CourseType::Short,
            'price_cents' => 2900,
            'duration_hours' => fake()->numberBetween(2, 8),
        ]);
    }

    public function paid(): static
    {
        return $this->state(fn () => [
            'type' => CourseType::Paid,
            'price_cents' => fake()->randomElement([7900, 9900, 14900]),
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn () => [
            'status' => CourseStatus::Draft,
            'published_at' => null,
        ]);
    }
}
